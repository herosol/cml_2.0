<?php

class Earnings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('withdraw_model');  
	}

	function index()
	{
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));

		$this->data['earningsPendings'] = $this->withdraw_model->get_earning_pending();
		foreach($this->data['earningsPendings'] as $key => $value)
		{
			if(get_dates_days($value->date, date('Y-m-d H:i:s')) >= $this->data['site_settings']->site_hold_payment)
			{
				$this->master->save('earnings', ['status'=> 'available'], 'id', $value->id);
			}
		}

		$this->data['bank_accounts']    = $this->master->get_data_rows('mem_bank_accounts', ['mem_id'=> $this->session->mem_id]);
		$this->data['earnings']         = $this->withdraw_model->get_earning();
		$this->data['availBalance']     = $this->withdraw_model->get_avail_balance();
		$this->data['requested']        = $this->withdraw_model->get_requested_balance();
		$this->data['payouts']          = $this->withdraw_model->get_payouts();
		$this->data['deliveries']       = $this->withdraw_model->count_rows_where(['mem_id'=> $this->session->mem_id, 'status'=> 'completed']);
		// pr($this->data);
        $this->load->view('vendor/earnings', $this->data);
	}

	function withdraw_request()
	{
		if($this->input->post())
		{
			$res = [];
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());

			if($post['payment_method'] == 'bank-account')
			{
				if($post['bank_check'] == 0)
				{
					$this->form_validation->set_rules('selected_bank', 'Bank', 'required|trim', ['required'=> 'Please select any bank if you don\'t have added before please enter new one.']);
				}
				else
				{
					$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
					$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
					$this->form_validation->set_rules('short_code', 'Short Code', 'trim|required');
					$this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'trim|required');
				}
			}
			else
			{
				$this->form_validation->set_rules('paypal_address', 'Paypal Address', 'required|trim');
			}

            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();
            if (!empty($res['msg']))
                exit(json_encode($res));

			$available_earning = $this->withdraw_model->get_earning_available();
			$availBalance      = $this->withdraw_model->get_avail_balance();
			$withdraw_data = [];
			if(count($available_earning) > 0)
			{
				$withdraw_data['mem_id'] = $this->session->mem_id;
				$withdraw_data['amount'] = $availBalance;
				$withdraw_data['payment_method'] = $post['payment_method'];
				if($post['payment_method'] == 'bank-account')
				{
					if($post['bank_check'] == 0)
					{
						$withdraw_data['bank_id'] = $post['selected_bank'];
					}
					else
					{
						$bank_detail = [];
						$bank_detail['bank_name']        = $post['bank_name'];
						$bank_detail['account_number']   = $post['account_number'];
						$bank_detail['short_code']       = $post['short_code'];
						$bank_detail['beneficiary_name'] = $post['beneficiary_name'];
						$bank_detail['mem_id'] = $this->session->mem_id;

						$bank_id = $this->master->save('mem_bank_accounts', $bank_detail);
						$withdraw_data['bank_id'] = $bank_id;
					}
				}
				else
				{
					$withdraw_data['paypal_address'] = $post['paypal_address'];
				}

				$withdraw_id = $this->withdraw_model->save($withdraw_data);

				if($withdraw_id)
				{
					foreach($available_earning as $key => $row):
						# INSERT into transaction details
						$trans_detail  = $this->master->save('withdrawal_detail', ['withdraw_id'=> $withdraw_id, 'earning_id'=> $row->id]);
						# Change AVailable to Requested AFTER INSERT
						$update_status = $this->master->save('earnings', ['status'=> 'requested'], 'id', $row->id);
					endforeach;

					$res['msg'] = showMsg('success', 'Transaction Success! Withdraw request has been sent to admin.');
					$res['status'] = 1;
				}
				else
				{
					$res['msg'] = showMsg('error', 'Transaction Failed! Please Contact To Admin.');
					$res['status'] = 0;
				}
			}
			else
			{
				$res['msg'] = showMsg('Info', 'You don\'t have sufficient balance for this transaction.');
				$res['status'] = 0;
			}
		}

		$res['hide_msg'] = 1;
		$res['frm_reset'] = 1;
		exit(json_encode($res));
	}

}
?>
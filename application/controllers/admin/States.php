<?php
class States extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        has_access(19);
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/states';
        $this->data['rows'] = $this->master->getRows('states');
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['pageView'] = ADMIN . '/states';
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            $this->master->save('states', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'State/Province has been saved successfully.');
            redirect( ADMIN . '/states', 'refresh');
            exit;
        }
        $this->data['row'] = $this->master->getRow('states',array('id'=>$this->uri->segment('4')));
        $this->data['page_title'] = $this->data['row'] ? "Edit State/Province" : "Add New State/Province";
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }

    function delete()
    {
        $this->master->delete('states', 'id', $this->uri->segment('4'));
        setMsg('success', 'State/Province has been deleted successfully.');
        redirect(ADMIN . '/states', 'refresh');
        exit;
    }
}
?>
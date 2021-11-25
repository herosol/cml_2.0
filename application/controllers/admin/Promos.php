<?php

class Promos extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('Promos_model','promos');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/promos';

        $this->data['rows'] = $this->promos->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['pageView'] = ADMIN . '/promos';
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            if (($_FILES["image"]["name"] != "")) {
                $this->remove_file($this->uri->segment(4));
                $image = upload_file(UPLOAD_PATH . "promos/", 'image');
                if (!empty($image['file_name'])) {
                    $vals['image'] = $image['file_name'];
                    generate_thumb(UPLOAD_PATH . "promos/", UPLOAD_PATH . "promos/", $image['file_name'],200,'thumb_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/promos/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            
            $this->promos->save($vals, $this->uri->segment(4));
            setMsg('success', 'Testimonial has been saved successfully.');
            redirect(ADMIN . '/promos', 'refresh');
            exit;
        }
        $this->data['row'] = $this->promos->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->promos->get_row($id)) {
            $this->promos->delete($this->uri->segment('4'));
            setMsg('success', 'Testimonial has been deleted successfully.');
            redirect(ADMIN . '/promos', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function remove_file($id) {
        $arr = $this->promos->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/promos/" . $arr->image;
        $filepath_thumb = "./" . UPLOAD_PATH . "/promos/thumb_" . $arr->image;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }

}

?>
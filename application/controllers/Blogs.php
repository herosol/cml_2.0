<?php
class Blogs extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blogs_model', 'blogs');
        // Per page limit
        $this->perPage = 6;
    }

    function index()
    {
        /*$meta = $this->page->getMetaContent('blog');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('blog');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/blog', $this->data);
        } else {
            show_404();
        }*/
        // Get posts data from the database
        $conditions['order_by'] = "id DESC";
        $conditions['limit'] = $this->perPage;
        $this->data['blogs'] = $this->blogs->getRows($conditions);

        $this->load->view('pages/blog', $this->data);
    }

    function blog_detail($blogId, $slug)
    {
        $blogId = doDecode($blogId);
        // $meta = $this->page->getMetaContent('blog');
        // $this->data['page_title'] = $meta->page_name;
        // $this->data['slug'] = $meta->slug;
        // $data = $this->page->getPageContent('blog');
        // if ($data) {
        //     $this->data['content'] = unserialize($data->code);
        //     $this->data['details'] = ($data->full_code);
        //     $this->data['meta_desc'] = json_decode($meta->content);
        // } else {
        //     show_404();
        // }
        $this->data['row'] = $this->master->get_data_row('blogs', ['id' => $blogId]);
        $this->load->view('pages/blog-detail', $this->data);
    }

    function load_more_data(){
        $conditions = array();
        
        // Get last post ID
        $lastID = $this->input->post('id');
        
        // Get post rows num
        $conditions['where'] = array('id <'=>$lastID);
        $conditions['returnType'] = 'count';
        $data['postNum'] = $this->blogs->getRows($conditions);
        
        // Get posts data from the database
        $conditions['returnType'] = '';
        $conditions['order_by'] = "id DESC";
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->blogs->getRows($conditions);
        
        $data['postLimit'] = $this->perPage;

        
        // Pass data to view
        $this->load->view('pages/load-more-data', $data, false);
    }

}

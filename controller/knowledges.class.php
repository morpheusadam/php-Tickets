<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class C_Knowledges extends M_Knowledges {

    public $knowledges_msg = '';

    public function __construct() {
        parent::__construct();
        add_action('ajax', array($this, 'add_knowledges'));
        add_action('ajax', array($this, 'ajax_search'));
    }

    public function add_knowledges() {
        if ($this->request->http_isset('knowledge_add', 'post')) {
            if ($this->request->http_empty('title', 'post')) {
                $this->knowledges_msg = alert_message('Error', __('required title input'), 'danger');
            } elseif ($this->request->http_empty('content', 'post')) {
                $this->knowledges_msg = alert_message('Error', __('required content input'), 'danger');
            } else {
                if ($this->request->http_post('knowledge_add') == 'new') {
                    $this->addKnowledges(
                            $this->request->http_post('title'), $this->request->http_post('allow_visitors'), $this->request->http_post('department'), $this->request->http_post('content', 'escape_html')
                    );
                } elseif ($this->request->http_post('knowledge_add') == 'edit') {
                    $this->editKnowledges(
                            $this->request->http_post('knowledge_id'), $this->request->http_post('title'), $this->request->http_post('allow_visitors'), $this->request->http_post('department'), $this->request->http_post('content', 'escape_html')
                    );
                }
                $this->knowledges_msg = $this->model_msg;
            }
            echo $this->knowledges_msg;
        }
    }

    public function delete_knowledges() {
        if ($this->request->http_isset('post_delete', 'post')) {
            if ($this->request->http_not_empty('post_id', 'post') and $this->request->http_is_int('post_id', 'post')) {
                $this->deleteKnowledges($this->request->http_post('post_id'));
            }
        }
    }

    public function like_knowledges() {
        if ($this->request->http_isset('post_like', 'post')) {
            if ($this->request->http_not_empty('post_id', 'post') and $this->request->http_is_int('post_id', 'post')) {
                $this->likeKnowledges($this->request->http_post('post_id'), $this->request->http_post('like_type'));
            }
        }
    }

    public function get_knowledges($num = NULL, $is_public = NULL) {
        $knowledges = $this->getKnowledges($num, $is_public);
        if (!empty($knowledges)) {
            return $knowledges;
        }
    }

    public function get_popular_knowledges($num = NULL, $is_public = NULL) {
        $knowledges = $this->get_popularKnowledges($num, $is_public);
        if (!empty($knowledges)) {
            return $knowledges;
        }
    }

    public function ajax_search() {
        if ($this->request->http_get('function') == 'ajax_search') {
            $data = array("alpha", "allpha2", "epsilon", "gamma", "zulu");
            echo json_encode($data);
        }
    }

}

$Knowledges = new C_Knowledges();
$Knowledges->delete_knowledges();
$Knowledges->like_knowledges();

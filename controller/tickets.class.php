<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class C_Tickets extends M_Tickets {

    public $tickets_msg = '';

    public function __construct() {
        parent::__construct();
        add_action('ajax', array($this, 'addEdit_department'));
        add_action('ajax', array($this, 'change_department'));
        add_action('ajax', array($this, 'add_ticket'));
        add_action('ajax', array($this, 'add_reply'));
    }

    public function add_ticket() {
        if ($this->request->http_isset('tickets_create', 'post')) {
            if ($this->request->http_not_empty('subject', 'post')) {
                if ($this->request->http_isset('tickets_is_user_create', 'post')) {
                    $this->addTicket($this->request->http_post('subject'), $this->request->http_post('department'), $this->request->http_post('priority'), $this->request->http_post('content', 'escape_html'), 'attachment', $this->request->http_post('tickets_create'));
                } else {
                    $this->addTicket($this->request->http_post('subject'), $this->request->http_post('department'), $this->request->http_post('priority'), $this->request->http_post('content', 'escape_html'), 'attachment', NULL);
                }
                if ($this->model_msg == 'error_type') {
                    $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid file type') . '
                                    </div>';
                } elseif ($this->model_msg == 'error_size') {
                    $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('file size bigger than') . ' ' . formatSize(Attach_Size) . '
                                    </div>';
                } else {
                    $this->tickets_msg = $this->model_msg;
                }
            } else {
                $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('required subject input') . '
                                    </div>';
            }
            echo $this->tickets_msg;
        }
    }

    public function add_reply() {
        if ($this->request->http_isset('tickets_reply', 'post')) {
            $id = str_replace('true_', '', $this->request->http_post('tickets_reply', 'escape_html'));
            if ($this->request->http_not_empty('tickets_reply', 'post') and $this->request->http_not_empty('content', 'post')) {
                $this->replyTicket($id, $this->request->http_post('content', 'escape_html'), 'attachment');
                if ($this->model_msg == 'error_type') {
                    $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid file type') . '
                                    </div>';
                } elseif ($this->model_msg == 'error_size') {
                    $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('file size bigger than') . ' ' . formatSize(Attach_Size) . '
                                    </div>';
                } else {
                    $this->tickets_msg = $this->model_msg;
                }
            } else {
                $this->tickets_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('required reply content') . '
                                    </div>';
            }
            echo $this->tickets_msg;
        }
    }

    public function addEdit_department() {
        if ($this->request->http_isset('department_add', 'post')) {
            if ($this->request->http_post('department_add') == 'new') {
                if ($this->request->http_not_empty('d_name', 'post')) {
                    $this->addDepartment($this->request->http_post('d_name'));
                    $this->tickets_msg = $this->model_msg;
                } else {
                    $this->tickets_msg = alert_message(__('Error'), 'required department name', 'danger');
                }
            } elseif ($this->request->http_post('department_add') == 'edit') {
                if ($this->request->http_not_empty('d_id', 'post') and $this->request->http_not_empty('d_name', 'post') and $this->request->http_is_int('d_id', 'post')) {
                    $this->editDepartment($this->request->http_post('d_name'), $this->request->http_post('d_id'));
                    $this->tickets_msg = $this->model_msg;
                } else {
                    $this->tickets_msg = alert_message(__('Error'), 'required department name', 'danger');
                }
            }
            echo $this->tickets_msg;
        }
    }

    public function delete_department() {
        if ($this->request->http_isset('department_delete', 'post')) {
            if ($this->request->http_not_empty('d_id', 'post') and $this->request->http_is_int('d_id', 'post')) {
                $this->deleteDepartment($_POST['d_id']);
            }
        }
    }

    public function get_departments($num = null) {
        $departments = $this->getDepartmets($num);
        if (!empty($departments)) {
            return $departments;
        }
    }

    public function add_rate() {
        if ($this->request->http_isset('add_rate', 'post')) {
            if ($this->request->http_not_empty('reply_id', 'post') and $this->request->http_is_int('reply_id', 'post')) {
                $this->addRate($this->request->http_post('rate_value'), $this->request->http_post('reply_id'), $this->request->http_get('id'));
            }
        }
    }

    public function close_ticket() {
        if ($this->request->http_isset('close_ticket', 'post')) {
            if ($this->request->http_is_int('id', 'get') and $this->request->http_get('id') == $this->request->http_post('t_id')) {
                $this->closeTicket($this->request->http_post('t_id'));
            }
        }
    }

    public function delete_reply() {
        if ($this->request->http_isset('delete_my_reply', 'post')) {
            if ($this->request->http_is_int('id', 'get') and $this->request->http_get('id') == $this->request->http_post('parent_id'))
                $this->deleteReply($this->request->http_post('reply_id'), $this->request->http_post('parent_id'));
        }
    }

    public function change_department() {
        if ($this->request->http_isset('change_department', 'post')) {
            $this->changeDepartment($this->request->http_post('change_department'), $this->request->http_post('ticket-department'));
        }
    }

}

$Tickets = new C_Tickets();
$Tickets->add_rate();
$Tickets->close_ticket();
$Tickets->delete_reply();
$Tickets->delete_department();
define('tickets_msg', $Tickets->tickets_msg);

<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class C_Users extends M_Users {

    public $users_msg = '';

    public function __construct() {
        parent::__construct();
        add_action('ajax', array($this, 'edit_profile'));
        add_action('ajax', array($this, 'add_user'));
        add_action('ajax', array($this, 'add_stuff'));
		add_action('ajax', array($this, 'add_sms'));
    }

    function login() {
        if ($this->request->http_isset('do_login', 'post')):
            if ($this->request->http_not_empty('email', 'post') and $this->request->http_not_empty('password', 'post')) {
                if (filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->do_login($this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('remember'));
                    $this->users_msg = $this->model_msg;
                } else {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
                }
            } else {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('inputs value empty') . ' 
                                    </div>';
            }
        endif;
    }
	public function add_sms(){
        if ($this->request->http_isset('send_sms', 'post')) {
            if ($this->request->http_not_empty('subject', 'post')) {
                if ($this->request->http_isset('sms_is_user_create', 'post')) {
                    $this->addSMS($this->request->http_post('subject'), $this->request->http_post('content', 'escape_html'), $this->request->http_post('send_sms'));
                } else {
                    $this->addSMS($this->request->http_post('subject'), $this->request->http_post('content', 'escape_html'), NULL);
                }
			}
			echo $this->users_msg = $this->model_msg;
		}
    }
    public function remmber_login() {
        if ($this->request->http_cookie('ah_tickets_email') and $this->request->http_cookie('ah_tickets_passowrd')) {
            if ($this->isset_login()) {
                return TRUE;
            } else {
                //echo 'email=' . $this->request->http_cookie('ah_tickets_email') . "<br>";
                //echo 'password=' . str_replace("'", "", $this->request->http_cookie('ah_tickets_passowrd')) . '<br>';
                $this->remmberLogin($this->request->http_cookie('ah_tickets_email'), str_replace("'", "", $this->request->http_cookie('ah_tickets_passowrd')));
                //header("location: " . Site_URL);
            }
        }
    }

    public function facebook_login() {
        if ($this->request->http_isset('fb_login', 'post')):
            if ($this->request->http_not_empty('id', 'post') and $this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                if (!filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
                } else {
                    $this->socialLogin('facebook', $this->request->http_post('id'), $this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('bio'));
                    $this->users_msg = $this->model_msg;
                }
            } else {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('empty data') . ' 
                                    </div>';
            }
        endif;
    }

    public function linked_login() {
        if ($this->request->http_isset('linked_login', 'post')):
            if ($this->request->http_not_empty('id', 'post') and $this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                if (!filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
                } else {
                    $this->socialLogin('linkedin', $this->request->http_post('id'), $this->request->http_post('name'), $this->request->http_post('email'));
                    $this->users_msg = $this->model_msg;
                }
            } else {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('empty data') . ' 
                                    </div>';
            }
        endif;
    }

    public function google_login() {
        if ($this->request->http_isset('google_login', 'post')):
            if ($this->request->http_not_empty('id', 'post') and $this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                if (!filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
                } else {
                    $this->socialLogin('google', $this->request->http_post('id'), $this->request->http_post('name'), $this->request->http_post('email'));
                    $this->users_msg = $this->model_msg;
                }
            } else {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('empty data') . ' 
                                    </div>';
            }
        endif;
    }

    public function register() {
        if ($this->request->http_isset('do_register', 'post')):
            if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post') and $this->request->http_not_empty('password', 'post')) {
                if (!$this->request->http_isset('agree', 'post')) {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('you must agree for privacy policy') . '
                                    </div>';
                } else if (!filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
                } else {
                    $this->do_register($this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('phone'));
                    $this->users_msg = $this->model_msg;
                }
            } else {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('inputs value empty') . ' 
                                    </div>';
            }
        endif;
    }

    public function add_user() {
        if ($this->request->http_isset('user_add', 'post')) {
            if ($this->request->http_post('user_add') == 'new') {
                if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post') and $this->request->http_not_empty('password', 'post')) {
                    $this->addUser($this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('activate'), $this->request->http_post('bio'), 'photo', $this->request->http_post('phone'));
                    $this->users_msg = $this->model_msg;
                } else {
                    $this->users_msg = alert_message(__('Error'), 'empty required data', 'danger');
                }
            } elseif ($this->request->http_post('user_add') == 'edit') {
                if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                    $this->editUser($this->request->http_post('u_id'), $this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('activate'), $this->request->http_post('bio'), 'photo', $this->request->http_post('phone'));
                    $this->users_msg = $this->model_msg;
                } else {
                    $this->users_msg = alert_message(__('Error'), 'empty required data', 'danger');
                }
            }
            echo $this->users_msg;
        }
    }

    public function edit_profile() {
        if ($this->request->http_isset('edit-profile', 'post')) {
            if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                $this->editProfile(get_session('user_id'), $this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), 1, $this->request->http_post('bio'), 'photo', $this->request->http_post('phone'));
                $this->users_msg = $this->model_msg;
            } else {
                $this->users_msg = alert_message(__('Error'), 'empty required data', 'danger');
            }
            echo $this->users_msg;
        }
    }

    public function add_stuff() {
        if ($this->request->http_isset('stuff_add', 'post')) {
            if ($this->request->http_post('stuff_add') == 'new') {
                if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post') and $this->request->http_not_empty('password', 'post')) {
                    $this->addStuff($this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('activate'), $this->request->http_post('stuff_department', 'escape_array'), $this->request->http_post('edit_customers'), $this->request->http_post('bio'), 'photo', $this->request->http_post('phone'));
                    $this->users_msg = $this->model_msg;
                } else {
                    $this->users_msg = alert_message(__('Error'), 'empty required data', 'danger');
                }
            } elseif ($this->request->http_post('stuff_add') == 'edit') {
                if ($this->request->http_not_empty('name', 'post') and $this->request->http_not_empty('email', 'post')) {
                    $this->editStuff($this->request->http_post('u_id'), $this->request->http_post('name'), $this->request->http_post('email'), $this->request->http_post('password'), $this->request->http_post('country'), $this->request->http_post('gender'), $this->request->http_post('activate'), $this->request->http_post('stuff_department', 'escape_array'), $this->request->http_post('edit_customers'), $this->request->http_post('bio'), 'photo', $this->request->http_post('phone'));
                    $this->users_msg = $this->model_msg;
                } else {
                    $this->users_msg = alert_message(__('Error'), 'empty required data', 'danger');
                }
            }
            echo $this->users_msg;
        }
    }

    public function forgot_password() {
        if ($this->request->http_isset('do_forgot', 'post')) {
            if ($this->request->http_empty('email', 'post')) {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('empty email value') . ' 
                                    </div>';
            } else if (!filter_var($this->request->http_post('email'), FILTER_VALIDATE_EMAIL)) {
                $this->users_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid your email') . '
                                    </div>';
            } else {
                $this->forgotPassword($this->request->http_post('email'));
                $this->users_msg = $this->model_msg;
            }
        }
    }

    public function active() {
        if ($this->request->http_not_empty('user_key', 'get')) {
            $this->active_account($this->request->http_get('user_key'));
            $this->users_msg = $this->model_msg;
        }
    }

    public function is_login() {
        if ($this->get('email') and $this->get('password')) {
            return true;
        } else {
            $_SESSION['login_redirect'] = urlencode(get_url());
            redirect_file(Site_URL . '/login/redirect=true');
        }
    }

    public function show_landing_is_not_login() {
        if ($this->get('email') and $this->get('password')) {
            return true;
        } else {
            redirect_file(Site_URL . '/main');
        }
    }

    public function isset_login() {
        if ($this->get('email') and $this->get('password')) {
            return true;
        } else {
            return false;
        }
    }

    public function is_not_login() {
        if (!$this->get('email') and ! $this->get('password')) {
            return true;
        } else {
            if ($this->get('login_redirect')) {
                redirect_file(urldecode($this->get('login_redirect')));
                unset($_SESSION['login_redirect']);
            } else {
                redirect_file(Site_URL);
            }
        }
    }

    public function is_admin() {
        if ($this->get('is_admin') == 1) {
            return true;
        }
    }

    public function is_stuff() {
        if ($this->get('is_admin') == 2) {
            return true;
        }
    }

    public function logout() {
        if ($this->get('email') and $this->get('password')) {
            $this->destroy();
            setcookie("ah_tickets_email", "", time() - 60000, '');
            setcookie("ah_tickets_passowrd", "", time() - 60000, '');
            redirect_file(Site_URL . '/login');
        } else {
            redirect_file(Site_URL . '/login');
        }
    }

    public function delete_user() {
        if (isset($_POST['user_delete'])) {
            if (!empty($_POST['u_id']) and is_numeric($_POST['u_id'])) {
                $this->deleteUser($_POST['u_id']);
            }
        }
    }

    public function get_users($num = null) {
        $users = $this->getUsers($num);
        if (!empty($users)) {
            return $users;
        }
    }

    public function get_stuff($num = null) {
        $stuff = $this->getStuff($num);
        if (!empty($stuff)) {
            return $stuff;
        }
    }
    public function active_by_sms(){
      if($this->request->http_isset('user_id','get')){
        if($this->request->http_isset('active_user','post')){
          $this->do_active_by_sms($this->request->http_get('user_id'),$this->request->http_post('activate_code'));
        }
      }
      else if(!$this->request->http_isset('user_id','get')){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('Page Not Found') . '
                                    </div>';
                                    die();
       }
      $this->users_msg = $this->model_msg;
      echo $this->users_msg;
    }

}

$Users = new C_Users();
$Users->login();
$Users->remmber_login();
$Users->register();
$Users->active();
$Users->forgot_password();
$Users->delete_user();
define('users_msg', $Users->users_msg);

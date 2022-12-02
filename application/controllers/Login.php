<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Login extends FrontEndController
{
    /**
    ** constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->database();
        $this->load->library('session');
    }

    /**
    ** Index Page for this controller.
    **/
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
    ** This function used to check the user is logged in or not
    **/
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->global['pageTitle'] = getlang('login_page_title', 'sys_data'); 
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "/frontend/login/default",  $this->global, '' , NULL);
        }
        else
        {
            redirect('user/dashboard');
        }
    }
    
    
    /**
    ** This function used to logged in user
    **/
    public function getlogin()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            
            $result = $this->login_model->getlogin($email, $password);
            
            if(!empty($result))
            {
                $lastLogin = $this->login_model->lastLoginInfo($result->userId);
                $sessionArray = array(
                    'userId'=>$result->userId,                    
                    'role'=>$result->roleId,
                    'roleText'=>$result->role,
                    'name'=>$result->name,
                    'lastLogin'=> $lastLogin->createdDtm,
                    'isLoggedIn' => TRUE
                );

                $this->session->set_userdata($sessionArray);
                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

                $loginInfo = array(
                    "userId"=>$result->userId, 
                    "sessionData" => json_encode($sessionArray), 
                    "machineIp"=>$_SERVER['REMOTE_ADDR'], 
                    "userAgent"=>getBrowserAgent(), 
                    "agentString"=>$this->agent->agent_string(), 
                    "platform"=>$this->agent->platform()
                );

                $this->login_model->lastLogin($loginInfo);
                
                redirect('/user/dashboard');
            }else{
                $this->session->set_flashdata('error', 'Email or password mismatch');
                redirect('login');
            }
        }
    }

    /**
    ** This function used to load forgot password view
    **/
    public function forgotpassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->global['pageTitle'] = 'Forgot Password'; 
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "/frontend/login/forgotpassword",  $this->global, '' , NULL);
        }
        else
        {
            redirect('dashboard');
        }
    }
    
    /**
    ** This function used to generate reset password request link
    **/
    function resetPasswordUser()
    {

        
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->security->xss_clean($this->input->post('login_email'));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();

                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                    }

                    $sendStatus = send_resetpass_link($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        //error
        
        
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('login');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->global['pageTitle'] = 'Create Password'; 
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "/frontend/login/newPassword",  $this->global, $data , NULL);
           
        }
        else
        {
            redirect('login');
        }
    }
    
    /**
    ** This function used to create new password for user
    **/
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);

                $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $name = $userInfo[0]->name;

                        $enable_pass_update_confirm = getConfigItem('enable_pass_update_confirm');
                        if(!empty($enable_pass_update_confirm)){
                            send_passchange_confirmation($email, $name);
                        }
                    }


                
                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }
            
            setFlashData($status, $message);

            redirect("login");
        }
    }

    function verify() {
        $result = $this->login_model->get_hash_value($_GET['email']); //get the hash value which belongs to given email from database
        if(!empty($result)){

            foreach ($result as $item){ $hash = $item->hash;}

            if($hash == $_GET['hash']){ 
                $this->login_model->verify_user($_GET['email']);
                $this->global['pageTitle'] = 'Activation'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "/frontend/login/activation",  $this->global, NULL , NULL);
            }

        }
        

        
    }
}

?>
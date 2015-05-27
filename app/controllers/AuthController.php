<?php



class AuthController extends BaseController {



	//protected $user;



	/**

     * Display the login page

     * @return View

     */

    public function getLogin() {

         if (Input::get('login_name')!="aungtnaing82@gmail.com" && Input::get('login_pwd')!="admin") {

                return View::make('emails.auth.login');

            } else {

                return Redirect::route('attendancelist');

            }

   }



    /**

     * Login action

     * @return Redirect

     */

    public function postLogin() {
        echo "postLogint";

        try {

            if (Input::get('login_name')=="aungtnaing82@gmail.com" && Input::get('login_pwd')=="admin") {

                return Redirect::route('StdAttendance');

            } else {

                return View::make('emails.auth.login');

            }

			}

			 catch (\Exception $e) {
                
			   	return Redirect::route('admin.login')->withErrors(array('login' => $e->getMessage()));

       		 }

    }



    /**

     * Logout action

     * @return Redirect

     */

    public function getLogout() {

        

        return View::make('admin.login');

    }



}
<?php

use Fuel\Core\Response;
use Fuel\Core\View;

/**
 * The Home Controller
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Home extends Controller_Base_Core
{

    public function before()
    {
        parent::before();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function action_index()
    {
        if (!Model_Base_User::is_login()) {
            Response::redirect('/signin');
        }

        $data = array();

        $this->template->title = 'Home Page';
        $this->template->content = View::forge($this->layout . '/home/index');
    }

    public function post_create_expense()
    {
        $data = [];
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('expense_name', 'Expense Name', 'required|max_length[255]');
        $val->add_field('expense_price', 'Expense Price', 'required|max_length[13]|valid_numeric');
        if ($val->run()) {
            $props = [
                'user_id' => $this->user_id,
                'expense_name' => (string) Model_Service_Util::mb_trim($val->validated('expense_name')),
                'expense_price' => (string) Model_Service_Util::mb_trim($val->validated('expense_price'))
            ];
            if (Model_Base_Expense::insert_expense($props)) {
                Log::write('NOTICE', 'Create expense success: ' . $this->email, static::$method);
            } else {
                Log::write('NOTICE', 'Create expense fail: ' . $this->email, static::$method);
            }

            $html = array();
            $html['expense_total'] = 0;
            $expenses = Model_Base_Expense::get_expense_list_by_user_id($this->user_id);
            foreach ($expenses as $expense) {
                $html['expenses'][] = $expense;
                $html['expense_total'] += $expense->expense_price;
            }

            return new Response(View::forge($this->layout . '/home/expense_list', $html));
        } else {
            $data['errors'] = $val->error_message();
        }

        return $this->response($data);
    }

    public function action_not_found()
    {
        $this->template->title = 'Page not found';
        $this->template->content = View::forge($this->layout . '/global/not_found');
    }
}

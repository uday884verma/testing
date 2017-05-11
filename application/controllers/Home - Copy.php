<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function get_headers($title)
	{ 
		$data['title'] = $title;
		$this->load->view('header', $data);
	}

	public function index()
	{ 
		$this->get_headers('Home');
		$this->load->view('home');
	}

	//function to add main question
	public function add_main_question()
	{
		$cnt = $_POST['cnt'];
		$main_cnt = $_POST['main_cnt'];
		$str = '';
		$str .= '<div class="input-group main_div" id="main_div_'.$cnt.'">
				<label>'.$main_cnt.'</label>
			  <input type="text" name="question_'.$cnt.'" id="question_'.$cnt.'" class="form-control col-md-8 required" placeholder="Question" >


			  <img src="'.base_url().'images/A.png" class="image_answer" style="width: 30px; height: 30px;"/>
			  <select name="answer_option_'.$cnt.'" id="answer_option_'.$cnt.'" class="form-control col-md-2 selectBox" onchange="change_answer_options(this.id)">
			  	<option value="single_choice">Single Choice</option>
			  	<option value="multi_choice">Multi Choice</option>
			  	<option value="multi_line">Multi-line Text</option>
			  </select>

			</div>
			<label for="question_'.$cnt.'" class="error" style="display:none; margin-left: 22px;">Please enter question</label>

			<div class="input-group col-md-8 main_div" id="single_answer_option_'.$cnt.'">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="single_choice_answer_'.$cnt.'" id="single_choice_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer">
				  <span id="single_answer_option_'.$cnt.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
			 </div>
			 <label for="single_choice_answer_'.$cnt.'" id="single_answer_option_'.$cnt.'_err" class="error" style="display:none; margin-left: 42px;">Please enter answer</label>

			 <div class="input-group col-md-8 main_div" id="multiline_answer_option_'.$cnt.'" style="display: none;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <textarea name="multiline_answer_'.$cnt.'" id="multiline_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer"></textarea>
			 </div>
			 <label for="multiline_answer_'.$cnt.'" id="multiline_answer_option_'.$cnt.'_err" class="error" style="display:none; margin-left: 42px;">Please enter answer</label>

			 <div id="multi_answer_option_'.$cnt.'" style="display: none;">';

			 for ($i=1; $i <=5 ; $i++) 
			 { 
			 	$str .= '<div class="input-group col-md-8 main_div" id="multi_answer_'.$cnt.'_'.$i.'_div">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="multi_answer_'.$cnt.'_'.$i.'" id="multi_answer_'.$cnt.'_'.$i.'" class="form-control col-md-4 required" placeholder="Answer">
				  <span id="multi_answer_'.$cnt.'_'.$i.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
				</div>';

				if($i == 1)
				{
					$str .= '<label for="multi_answer_'.$cnt.'_1" id="multi_answer_option_'.$cnt.'_1_err" class="error" style="display:none; margin-left: 42px;">Please enter atleast one answer</label>';
				}
			 }
			 
			 

			 $str .= '</div>
			 
			 ';

			 echo $str;
		exit;
	}

	//function to add sub question
	public function add_sub_question()
	{
		$cnt = $_POST['cnt'];
		$str = '';
		$str .= '
				<div style="margin-left: 40px !important;" class="col-md-12">

				<div class="input-group main_div" id="main_div_'.$cnt.'">
				<img src="'.base_url().'images/Q.png" class="image_answer" style="width: 35px; height: 30px;"/>
			  <input type="text" name="question_'.$cnt.'" id="question_'.$cnt.'" class="form-control col-md-8 required" placeholder="Question" >


			  <img src="'.base_url().'images/A.png" class="image_answer" style="width: 30px; height: 30px;"/>
			  <select name="answer_option_'.$cnt.'" id="answer_option_'.$cnt.'" class="form-control col-md-2 selectBox" onchange="change_answer_options(this.id)">
			  	<option value="single_choice">Single Choice</option>
			  	<option value="multi_choice">Multi Choice</option>
			  	<option value="multi_line">Multi-line Text</option>
			  </select>

			</div>
			<label for="question_'.$cnt.'" class="error" style="display:none; margin-left: 22px;">Please enter question</label>

			<div class="input-group col-md-8 main_div" id="single_answer_option_'.$cnt.'" style="margin-left: 51px !important;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="single_choice_answer_'.$cnt.'" id="single_choice_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer">
				  <span id="single_answer_option_'.$cnt.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
			 </div>
			 <label for="single_choice_answer_'.$cnt.'" id="single_answer_option_'.$cnt.'_err" class="error" style="display:none; margin-left: 42px;">Please enter answer</label>

			 <div class="input-group col-md-8 main_div" id="multiline_answer_option_'.$cnt.'" style="display: none;" style="margin-left: 51px !important;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <textarea name="multiline_answer_'.$cnt.'" id="multiline_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer"></textarea>
			 </div>
			 <label for="multiline_answer_'.$cnt.'" id="multiline_answer_option_'.$cnt.'_err" class="error" style="display:none; margin-left: 42px;">Please enter answer</label>

			 <div id="multi_answer_option_'.$cnt.'" style="display: none; margin-left: 51px !important;">';

			 for ($i=1; $i <=5 ; $i++) 
			 { 
			 	$str .= '<div class="input-group col-md-8 main_div" id="multi_answer_'.$cnt.'_'.$i.'_div">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="multi_answer_'.$cnt.'_'.$i.'" id="multi_answer_'.$cnt.'_'.$i.'" class="form-control col-md-4 required" placeholder="Answer">
				  <span id="multi_answer_'.$cnt.'_'.$i.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
				</div>';

				if($i == 1)
				{
					$str .= '<label for="multi_answer_'.$cnt.'_1" id="multi_answer_option_'.$cnt.'_1_err" class="error" style="display:none; margin-left: 42px;">Please enter atleast one answer</label>';
				}
			 }
			 
			 

			 $str .= '</div>
			 </div>
			 ';

			 echo $str;
		exit;
	}
}

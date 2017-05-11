<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);

class Home extends CI_Controller {

	public function get_headers($title)
	{ 
		$data['title'] = $title;		//to show title of page
		$this->load->view('header', $data);		//loads the view file
	}

	//index function i.e. default function
	public function index()
	{ 
		if($this->input->post()) 		//checking if form is submitted
		{ 
			$created_datetime = strtotime(date('Y-m-d H:i:s'));		//geeting current date time
			$total = $this->input->post('cnt');		//total no. of questions
			$result = $this->input->post();
			
			for ($i=1; $i<=$total; $i++) 
			{ 
				$answer_type = $this->input->post('answer_option_'.$i);
				$question = htmlentities($this->input->post('question_'.$i));

				if($answer_type == 'single_choice')		//if the answer is of single type
				{
					$answer = htmlentities($this->input->post('single_choice_answer_'.$i));
					if($question!='' && $answer!='')
					{
						//to save question in table
						$arr_question = array( 'question' => $question, 'created_datetime' => $created_datetime );
						$sql_question = $this->common_model->insert_data($arr_question, 'questions');

						$arr = array( 'question_id' => $sql_question, 'answer' => $answer, 'created_datetime' => $created_datetime );
						//checking parent or child
						$parent = $this->input->post('parent_'.$i);
						$parent_new = array();
						$parent_new = explode("_", $parent);
						if(end($parent_new) == 0)
						{
							$arr['parent_id'] = 0;
							$sql = $this->common_model->insert_data($arr, 'answers');
						}
						else
						{
							if($parent_new[0]=='single' && $result['answer_current_'.$parent_new[3].'_1'])
							{
								$arr['parent_id'] = $result['answer_current_'.$parent_new[3].'_1'];	//change to updated id
								$sql = $this->common_model->insert_data($arr, 'answers');
							}
							else if($parent_new[0]=='multi' && $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]])
							{
								$arr['parent_id'] = $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]];	//change to updated id
								$sql = $this->common_model->insert_data($arr, 'answers');
							}
							
						}
						$result['answer_current_'.$i.'_1'] = $sql;
					}
					else
					{
						echo "<script>alert('Please fill complete data');</script>";
					}
				}

				else if($answer_type == 'multi_choice')		//if the answer is of multi text type
				{
					//to save question
					if($question!='')
					{
						$arr_question = array( 'question' => $question, 'created_datetime' => $created_datetime );
						$sql_question = $this->common_model->insert_data($arr_question, 'questions');
					}
						
						
					for ($j=1; $j <= 5; $j++) 		//looping for multiple textboxes
					{ 
						$answer = htmlentities($this->input->post('multi_answer_'.$i.'_'.$j));
						if($question!='' && $answer!='')
						{
							$arr = array( 'question_id' => $sql_question, 'answer' => $answer, 'created_datetime' => $created_datetime );
							//checking parent or child
							$parent = $this->input->post('parent_'.$i);
							$parent_new = array();
							$parent_new = explode("_", $parent);
								
							if(end($parent_new) == 0)
							{
								$arr['parent_id'] = 0;
								$sql = $this->common_model->insert_data($arr, 'answers');
							}
							else
							{
								if($parent_new[0]=='single' && $result['answer_current_'.$parent_new[3].'_1'])
								{
									$arr['parent_id'] = $result['answer_current_'.$parent_new[3].'_1'];	//change to updated id
									$sql = $this->common_model->insert_data($arr, 'answers');
								}
								else if($parent_new[0]=='multi' && $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]])
								{
									$arr['parent_id'] = $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]];	//change to updated id
									$sql = $this->common_model->insert_data($arr, 'answers');
								}
							}
							$result['answer_current_'.$i.'_'.$j] = $sql;
						}
					}
				}

				else if($answer_type == 'multi_line')		//if the answer is of multiline
				{
					$answer = htmlentities($this->input->post('multiline_answer_'.$i));
					//to save question
					if($question!='')
					{
						$arr_question = array( 'question' => $question, 'created_datetime' => $created_datetime );
						$sql_question = $this->common_model->insert_data($arr_question, 'questions');
					}
					
					if($question!='' && $answer!='')
					{
						$arr = array( 'question' => $sql_question, 'answer' => $answer, 'created_datetime' => $created_datetime );
						//checking parent or child
						$parent = $this->input->post('parent_'.$i);
						$parent_new = array();
						$parent_new = explode("_", $parent);
						if(end($parent_new) == 0)
						{
							$arr['parent_id'] = 0;
							$sql = $this->common_model->insert_data($arr, 'answers');
						}
						else
						{
							
							if($parent_new[0]=='single' && $result['answer_current_'.$parent_new[3].'_1'])
							{
								$arr['parent_id'] = $result['answer_current_'.$parent_new[3].'_1'];	//change to updated id
								$sql = $this->common_model->insert_data($arr, 'question_answers');
							}
							else if($parent_new[0]=='multi' && $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]])
							{
								$arr['parent_id'] = $result['answer_current_'.$parent_new[2].'_'.$parent_new[3]];	//change to updated id
								$sql = $this->common_model->insert_data($arr, 'question_answers');
							}
						}
						$result['answer_current_'.$i.'_1'] = $sql;
					}
					else
					{
						echo "<script>alert('Please fill complete data');</script>";
					}
				}
			}
			echo "<script>alert('Your data has been saved successfully');</script>";
		}
		$this->get_headers('Home');
		$this->load->view('home');
	}

	//function to add main question
	public function add_main_question()
	{
		$cnt = $this->input->post('cnt');
		$main_cnt = $this->input->post('main_cnt');
		$str = '';
		$str .= '<div class="input-group main_div" id="main_div_'.$cnt.'">
				<label>'.$main_cnt.'</label>

				<input type="hidden" name="parent_'.$cnt.'" id="parent_'.$cnt.'" value="0" />
				
			  <input type="text" name="question_'.$cnt.'" id="question_'.$cnt.'" class="form-control col-md-8 required" minlength="3" maxlength="150" placeholder="Question" >


			  <img src="'.base_url().'images/A.png" class="image_answer" style="width: 30px; height: 30px;"/>
			  <select name="answer_option_'.$cnt.'" id="answer_option_'.$cnt.'" class="form-control col-md-2 selectBox" onchange="change_answer_options(this.id)">
			  	<option value="single_choice">Single Choice</option>
			  	<option value="multi_choice">Multi Choice</option>
			  	<option value="multi_line">Multi-line Text</option>
			  </select>

			</div>
			

			<div class="input-group col-md-8 main_div" id="single_answer_option_'.$cnt.'">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="single_choice_answer_'.$cnt.'" id="single_choice_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer"  minlength="3" maxlength="150">
				  <span id="single_answer_option_'.$cnt.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
			 </div>
			 

			 <div class="input-group col-md-8 main_div" id="multiline_answer_option_'.$cnt.'" style="display: none;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <textarea name="multiline_answer_'.$cnt.'" id="multiline_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer"  minlength="3" maxlength="250"></textarea>
			 </div>
			 

			 <div id="multi_answer_option_'.$cnt.'" style="display: none;">';

			 for ($i=1; $i <=5 ; $i++) 		//will create dynamic multi textboxes
			 { 
			 	$req = '';
			 	if($i == 1) { $req = 'required'; }
			 	$str .= '<div class="input-group col-md-8 main_div" id="multi_answer_'.$cnt.'_'.$i.'_div">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="multi_answer_'.$cnt.'_'.$i.'" id="multi_answer_'.$cnt.'_'.$i.'" class="form-control col-md-4 '.$req.'" placeholder="Answer" minlength="3" maxlength="150">
				  <span id="multi_answer_'.$cnt.'_'.$i.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
				</div>';

			 }
			 
			 

			 $str .= '</div>
			 
			 ';

			 echo $str;
		exit;
	}

	//function to add sub question
	public function add_sub_question()
	{
		$cnt = $this->input->post('cnt');
		$strdiv = $this->input->post('strdiv');
		$str = '';
		$str .= '
				<div style="margin-left: 40px !important;" class="col-md-12" id="'.$strdiv.'_sub">

				<input type="hidden" name="parent_'.$cnt.'" id="parent_'.$cnt.'" value="'.$strdiv.'" />
				
				<div class="input-group main_div" id="main_div_'.$cnt.'">
				<img src="'.base_url().'images/Q.png" class="image_answer" style="width: 35px; height: 30px;"/>
			  <input type="text" name="question_'.$cnt.'" id="question_'.$cnt.'" class="form-control col-md-8 required" placeholder="Question"  minlength="3" maxlength="150">


			  <img src="'.base_url().'images/A.png" class="image_answer" style="width: 30px; height: 30px;"/>
			  <select name="answer_option_'.$cnt.'" id="answer_option_'.$cnt.'" class="form-control col-md-2 selectBox" onchange="change_answer_options(this.id)">
			  	<option value="single_choice">Single Choice</option>
			  	<option value="multi_choice">Multi Choice</option>
			  	<option value="multi_line">Multi-line Text</option>
			  </select>

			</div>
			

			<div class="input-group col-md-8 main_div" id="single_answer_option_'.$cnt.'" style="margin-left: 51px !important;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="single_choice_answer_'.$cnt.'" id="single_choice_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer" minlength="3" maxlength="150">
				  <span id="single_answer_option_'.$cnt.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
			 </div>
			 

			 <div class="input-group col-md-8 main_div" id="multiline_answer_option_'.$cnt.'" style="display: none;" style="margin-left: 51px !important;">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <textarea name="multiline_answer_'.$cnt.'" id="multiline_answer_'.$cnt.'" class="form-control col-md-4 required" placeholder="Answer" minlength="3" maxlength="250"></textarea>
			 </div>
			 

			 <div id="multi_answer_option_'.$cnt.'" style="display: none; margin-left: 51px !important;">';

			 for ($i=1; $i <=5 ; $i++) 		//will create dynamic multi textboxes
			 { 
			 	$req = '';
			 	if($i == 1) { $req = 'required'; }
			 	$str .= '<div class="input-group col-md-8 main_div" id="multi_answer_'.$cnt.'_'.$i.'_div">
				  <i class="fa fa-arrow-right set_center" aria-hidden="true"></i>
				  <input type="text" name="multi_answer_'.$cnt.'_'.$i.'" id="multi_answer_'.$cnt.'_'.$i.'" class="form-control col-md-4 '.$req.'" placeholder="Answer" minlength="3" maxlength="150">
				  <span id="multi_answer_'.$cnt.'_'.$i.'_span" class="sub_questions col-md-4 set_center" onclick="add_sub_question(this.id)">+ Add Sub Question</span>
				</div>';

			 }
			 
			 

			 $str .= '</div>
			 </div>
			 ';

			 echo $str;
		exit;
	}
}

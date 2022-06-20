<?php
namespace App\MyClasses;

use Carbon\Carbon;
use View;
class Widgets{
	
	private $label;
	private $type;
	private $name;
	private $goal;
	private $table;
	private $color;

	



	public function set_label($label){
		$this->label=$label;
	}
	public function set_type($type){
		$this->type=$type;
	}
	public function set_name($name){
		$this->name=$name;
	}
	public function set_goal($goal){
		$this->goal=$goal;
	}
	public function set_table($table){
		$this->table=$table;
	}
	public function set_color($color){
		$this->color=$color;
	}


	public function get_label(){
		return $this->label;
	}
	public function get_type(){
		return $this->type;
	}
	public function get_name(){
		return $this->name;
	}
	public function get_goal(){
		return $this->goal;
	}
	public function get_table(){
		return $this->table;
	}
	public function get_color(){
		return $this->color;		
	}


	public function render(){
		switch($this->type){
			case 'monthly':
    			$view=View::make('widgets.easy_pie_chart', ['widget_name'=>$this->get_name(), 'widget_color'=>$this->get_color()]);
    			$data['html'] = $this->create_init(); 
    			$data['triggers'] = $this->create_triggers();
    			$data['js'] = $view->render();
			break;
		}
		return $data;
	}


	public function create_init(){
		$data['widget_name'] = $this->get_name();
		$data['label'] = $this->get_label();
		$data['color'] = $this->get_color();
		$date = Carbon::now();
		$data['current_month'] = Carbon::now()->format('F');
		$data['year'] = $date->year;
		$data['monthly_goal'] = $this->goal; //max value
		$data['new_monthly_properties'] = $this->get_records_created_during_this_month($this->table)->count();
		$data['progress'] = floor(($data['new_monthly_properties'] / $data['monthly_goal']) * 100);
		$view=View::make('widgets.widget_init', $data);
		return $view->render();
	}

	public function create_triggers(){
		$data['widget_name'] = $this->get_name();
		$data['goal'] = $this->get_goal();
		$view=View::make('widgets.easy_pie_chart_trigger', $data);
		return $view->render();
	}

	public function get_records_created_during_this_month($table=null){

		$model="App\\".$table;
		$now=Carbon::now();
		$start_of_month=Carbon::now()->startOfMonth();
        $obj=$model::whereBetween('created_at', [$start_of_month,$now])->get();
			
    	return $obj;

	}
}

?>
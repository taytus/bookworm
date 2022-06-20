<?php
namespace App\MyClasses;

use Carbon\Carbon;
use View;
class Counters{
	
	private $name;
	private $owner_id;
	private $table;
	private $type;
	private $label;
	private $color;
	private $icon;

	



	public function set_name($name){
		$this->name=$name;
	}
	public function set_owner_id($owner_id){
		$this->owner_id=$owner_id;
	}
	public function set_table($table){
		$this->table=$table;
	}
	public function set_type($type){
		$this->type=$type;
	}
	public function set_label($label){
		$this->label=$label;
	}
	public function set_color($color){
		$this->color=$color;
	}
	public function set_icon($icon){
		$this->icon=$icon;
	}


	public function get_name(){
		return $this->name;
	}
	public function get_owner_id(){
		return $this->owner_id;
	}
	public function get_table(){
		return $this->table;
	}
	public function get_type(){
		return $this->type;
	}
	public function get_label(){
		return $this->label;
	}
	public function get_color(){
		return $this->color;		
	}
	public function get_icon(){
		return $this->icon;
	}


	public function render(){
		switch($this->type){
			case 'monthly':
				$data['new_monthly_count'] = $this->get_records_created_during_this_month($this->table, $this->get_owner_id());
    			$view=View::make('counters.counters', ['counter_name'=>$this->get_name(),'new_monthly_count'=>$data['new_monthly_count'], 'scripts'=>false ]);
    			$data['html'] = $this->create_init(); 
    			$data['triggers'] = $this->create_triggers();
    			$data['js'] = $view->render();
			break;
		}
		return $data;
	}


	public function create_init(){
		$data['counter_name'] = $this->get_name();
		$data['label'] = $this->get_label();
		$data['color'] = $this->get_color();
		$date = Carbon::now();
		$data['current_month'] = Carbon::now()->format('F');
		$data['year'] = $date->year;
		$data['icon'] = $this->icon; 
		$view=View::make('counters.counter_init', $data);
		return $view->render();
	}

	public function create_triggers(){
		$data['counter_name'] = $this->get_name();
		$view=View::make('counters.counter_trigger', $data);
		return $view->render();
	}

	public function get_records_created_during_this_month($table=null, $owner_id=null){

		$model="App\\".$table;
		$now=Carbon::now();
		$start_of_month=Carbon::now()->startOfMonth();

        if($model == 'App\customer'){
        	$obj=$model::whereBetween('created_at', [$start_of_month,$now])->where('user_id', $owner_id)->get()->count();
    			return $obj;
        }

        if($model == 'App\property'){
        	$property_array = [];
        	$customers = \App\Customer::where('user_id', $owner_id)->get();

        	foreach($customers as $customer){
        		$properties = $customer->properties;
        		foreach($properties as $property){
        			if($property->created_at >= $start_of_month && $property->created_at <= $now){
        				array_push($property_array, $property);
        			}
        		}
        	}
    		$obj = count($property_array);
			return $obj;
        }


	}
}

?>
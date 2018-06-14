<?php
	namespace Common\Model;
	use Think\Model;
	/**
	* 公共model类
	*/
	class  CommonModel extends Model
	{
		/*	
			获取单条数据
			$where 条件
		*/
		public function getInfo($where){
			return $this->where($where)->find();
		}


		// 添加数据
		public function addDate($data){
			return $this->add($data);
		}


		// 查询数据列表
		/**
		* $where 查询条件
		* $field 查询字段
		* $order 排序
		* $type  是否分页
		* return array 结果
		**/
		public function selectList($where = [] ,$field = '*',$order = 'id desc',$type = ''){
			if($type){
				// 分页
				import('Page',APP_PATH.'/Common/Org');
				$count = $this->where($where)->count();
				$Page = new \Page($count,C('PAGE_SIZE'));
				$Page->rollPage = 5;
				$Page->setConfig('prev','<<');
				$Page->setConfig('next','>>');
				$list = $this->where($where)->order($order)->limit($Page->firstRow.','.$Page->lastRow)->select();
				$show = $Page->show();
				return ['list'=>$list,'show'=>$show,'order'=>$order];
			}else{
				return $this->where($where)->field($field)->order($order)->select();
			}
		}


		// 修改或者添加
		public function operationInfo($data = [],$field = ''){
			if(!empty($field)){
				if(isset($data[$field]) && $data[$field] >0){
					$value = $data[$field];
					unset($data[$field]);
					$this->where(array($field=>$value))->save($data);
					return true;
				}
			}else{
				return $this->add($data);
			}

		}


		// 获取符合条件的数据个数
		public function getInfoNum($where){
			return $this->where($where)->count();
		}



		// 多表联查所有信息
		public function MultiTablelSelectList($table,$where = [] ,$field = '*',$order = 'id desc',$type = ''){
			if($type){
				// 分页
				import('Page',APP_PATH.'/Common/Org');
				$count = $this->table($table)->where($where)->count();
				$Page = new \Page($count,C('PAGE_SIZE'));
				$Page->rollPage = 5;
				$Page->setConfig('prev','<<');
				$Page->setConfig('next','>>');
				$list = $this->table($table)->where($where)->field($field)->order($order)->limit($Page->firstRow.','.$Page->lastRow)->select();
				$show = $Page->show();
				return ['list'=>$list,'show'=>$show,'order'=>$order];
			}else{
				return $this->table($table)->where($where)->field($field)->order($order)->select();
			}
		}


	}





?>
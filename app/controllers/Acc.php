<?php
  class Acc extends Controller
  {
		public function __construct()
		{
			$this->doctorModel = $this->model('Doctor');
			$this->receptionModel = $this->model('Reception');
		}

		public function index()
		{
			$this->view('acc/index');
		}


		public function reports()
		{
			$this->view('acc/reports');
		}	

		      public function today_report()
      {
          $today_date = date('Y-m-d');
          $tdy = date('Y-m-d');
          $ord_count = $this->receptionModel->get_order_count_today($tdy);
          $revenue = $this->receptionModel->get_revenue_count($tdy);
          $discount = $this->receptionModel->get_discount_count($tdy);
          $data = [
            'ord_count' => $ord_count,
            'rev' => $revenue,
            'dis' => $discount,
            'date_filter' => $today_date
          ];
          $this->view('acc/get_report', $data);
      }	

      public function monthly_report()
      {
          $month_date = date('Y-m-01');
          $mnt = date('Y-m-01');
          $mntl = date('Y-m-31');
          $today = date('Y-m-d');
          $ord_count = $this->receptionModel->get_order_count_month($mnt, $mntl);
          $revenue = $this->receptionModel->get_revenue_count_month($mnt, $mntl);
          $discount = $this->receptionModel->get_discount_count_month($mnt, $mntl);
          $data = [
            'ord_count' => $ord_count,
            'rev' => $revenue,
            'dis' => $discount,
            'month_date' => $month_date,
            'today' => $today
          ];
          $this->view('acc/get_report', $data);
      }

       public function yearly_report()
      {
          $year_date = date('Y-01-01');
          $today =date('Y-m-d');
          $yr = date('Y-01-01');
          $yrl = date('Y-12-31');
          $ord_count = $this->receptionModel->get_order_count_yr($yr, $yrl);
          $revenue = $this->receptionModel->get_revenue_count_yr($yr, $yrl);
          $discount = $this->receptionModel->get_discount_count_yr($yr, $yrl);
          $data = [
            'ord_count' => $ord_count,
            'rev' => $revenue,
            'dis' => $discount,
            'year_date' => $year_date,
            'today' => $today
          ];  
          $this->view('acc/get_report', $data);
      }	
  }
?>
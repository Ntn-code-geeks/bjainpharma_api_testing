<?php





defined('BASEPATH') OR exit('No direct script access allowed');











/* 





 * Niraj Kumar

 * Dated: 30/10/2017

 * 

 * This Controller is for Report





 */











class Report extends Parent_admin_controller {
   function __construct() 
   {
      parent::__construct();
      $loggedData=logged_user_data();
      if(empty($loggedData)){
        redirect('user'); 
      }
      $this->load->library('excel');
      $this->load->model('report/report_model','report');
      $this->load->model('user_model','user');
      $this->load->model('dealer/Dealer_model','dealer');
      $this->load->model('permission/Permission_model','permission');
    }



  public function index($userid=''){ 

  

    $data['title'] = "Report List";

    $data['page_name'] = "Reports";

    $data['action2'] ="admin_control/report/cust_relationship";

    $data['action'] ="admin_control/report/sale_travel";

    $data['users']=array();



    $data['user_id']='';

    if($userid=='')

    {
      if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

      

    //  $data['sale'] =$this->report->travel_report_doctor();

    //  $data['sale'] =$this->report->relationship_report_dealer();



          $data['users'] =$this->user->users_report();

          $data['dealer_list']= $this->report->dealer_list();

          $data['pharma_list']= $this->report->pharmacy_list();

    //        pr($data['sample_data']); die;

         

        }



        else{

          redirect('user'); 

        }

    }

    else

    {

      $data['user_id']=urisafedecode($userid);

      $data['dealer_list']= $this->dealer->dealer_list();

      $cities_are = logged_user_cities();

      $data['pharma_list']= json_encode($this->permission->pharmacy_list($cities_are));

    }



    

    $this->load->get_view('report/report_view',$data);

  }

  public function get_tada_report($userid=''){ 
    $data['title'] = "TA DA Report List";
    $data['page_name'] = "TA DA Report List";
    $data['action'] ="admin_control/report/generate_tada_report";
    $data['users']=array();
    $data['user_id']='';
     if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
        $data['users'] =$this->user->users_report();
      }
      else{
        redirect('user'); 
      }
    $this->load->get_view('report/tada_report_view',$data);
}

public function generate_tada_report(){

  if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
    $request = $this->input->post();

    $report_date = explode('-',$request['report_date'] );
    $followstart_date =  trim($report_date[0]);
    $newstartdate = str_replace('/', '-', $followstart_date);
    $followend_date =  trim($report_date[1]);
    $newenddate = str_replace('/', '-', $followend_date);
    $start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";
    $end = date('Y-m-d', strtotime($newenddate))." 23:59:59";
    $this->load->library('form_validation');
    $this->form_validation->set_rules('user_id', 'User', 'required');
    $this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 
    if($this->form_validation->run() == TRUE){
      $this->show_tada_report($request['user_id'],$start,$end);
      //$data['attendance_report'] =$this->user_report->get_attendance_report($request['user_id'],$start,$end);
    }else{
      // for false validation
      $this->get_tada_report();  
    }
 
  }
  else{
    redirect('user');
  }
}

public function show_tada_report($userid,$start,$end)
{
    $totalrow=0;
    $gtrow=0;
    $gtkms=0;
    $gtta=0;
    $gtda=0;
    $gtpostage=0;
    $lastdaydestination=0;
    $this->excel->setActiveSheetIndex(0);
        //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Attendance Report');
    $styleArray = array(
        'font'  => array(
            'bold'  => true,
            //'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //'color' => array('rgb' => 'FFFF00'),
            'size'  => 12,
            //'name'  => 'Verdana'
        ));
     $styleArray2 = array(
        'font'  => array(
            'bold'  => true,
            //'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //'color' => array('rgb' => 'FFFF00'),
            'size'  => 18,
            //'name'  => 'Verdana'
        ));
     $styleArray1 = array(
        'font'  => array(
            'bold'  => true,
            //'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //'color' => array('rgb' => 'FFFF00'),
            'size'  => 22,
            'name'  => 'Algerian'
        ));
     
    $this->excel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->getStyle('A5:K5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
    $this->excel->getActiveSheet()->mergeCells('A1:K2');
    $this->excel->getActiveSheet()->getStyle('A1:K2')->applyFromArray($styleArray1);
    $this->excel->getActiveSheet()->getStyle('A1:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
   // $this->excel->getActiveSheet()->getStyle("A1:J2")->getFont()->setSize(22);
    $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->setCellValue('A1', 'B.JAIN PHARMACEUTICALS PVT. LTD.');
    //set cell A1 content with some text
    $this->excel->getActiveSheet()->mergeCells('A3:C3');

    $this->excel->getActiveSheet()->mergeCells('D3:H4');
    $this->excel->getActiveSheet()->getStyle('D3:H4')->applyFromArray($styleArray2);
    $this->excel->getActiveSheet()->getStyle('D3:H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('32CD32');
    $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->setCellValue('D3', 'EXPENSE STATEMENT');
    $this->excel->getActiveSheet()->getStyle("A3:C3")->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('A3', 'NAME : '.get_user_name($userid));
    $this->excel->getActiveSheet()->mergeCells('A4:C4');
    $this->excel->getActiveSheet()->getStyle("A4:C4")->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('A4', 'HQ : '.get_city_name(get_user_deatils($userid)->headquarters_city));

    $this->excel->getActiveSheet()->mergeCells('I3:K3');
    $this->excel->getActiveSheet()->getStyle("I3:K3")->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('I3', 'FROM : '.date('d/m/Y',strtotime($start)));
    $this->excel->getActiveSheet()->mergeCells('I4:K4');
    $this->excel->getActiveSheet()->getStyle("I4:K4")->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('I4', 'TO : '.date('d/m/Y',strtotime($end)));

    $this->excel->getActiveSheet()->setCellValue('A5', 'Filled DATES');
    $this->excel->getActiveSheet()->setCellValue('B5', 'Interaction DATES');
    $this->excel->getActiveSheet()->setCellValue('C5', 'FROM');
    $this->excel->getActiveSheet()->setCellValue('D5', 'CITY WORKED');
    $this->excel->getActiveSheet()->setCellValue('E5', 'TO');
    $this->excel->getActiveSheet()->setCellValue('F5', 'KMS(Google)');
    $this->excel->getActiveSheet()->setCellValue('G5', 'T.A.');
    $this->excel->getActiveSheet()->setCellValue('H5', 'D.A.');
    $this->excel->getActiveSheet()->setCellValue('I5', 'POSTAGE');
    $this->excel->getActiveSheet()->setCellValue('J5', 'TOTAL');
    $this->excel->getActiveSheet()->setCellValue('K5', 'Remark');
    $data['tada_report'] =$this->report->get_tada_report($userid,$start,$end);
    $k_num = 6;
    /* pr($data['attendance_report']);die; */ 
    /* For Attendance */
    if(!empty($data['tada_report'])){
      foreach ($data['tada_report']as $key=>$row){ 
        $da=0;
        $hqdistance=0;
        $nxtdestination=0;
        if($key==0)
        {
          $lastdaydestination=get_destination_before($userid,$start);
        }
        else
        {
          $lastdaydestination=$row['destination_city'];
        }
        $hqdistance=get_distance_hq($userid,$row['meet_id']);
        $hq= get_user_deatils($userid)->headquarters_city;
        $tpinfo=get_tp_interaction($userid,$row['source_city'],$row['destination_city'],$row['doi']);
        $this->excel->getActiveSheet()->getStyle("A".$k_num)->getFont()->getColor()->setRGB('808080');
        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['created_date'])));
        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, date('d.m.Y',strtotime($row['doi'])));
        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, get_city_name($row['source_city']));
        if($row['up_down'])
        {
          $this->excel->getActiveSheet()->setCellValue('E'.$k_num, get_city_name(get_user_deatils($userid)->headquarters_city));
        }
        else
        {
          $this->excel->getActiveSheet()->setCellValue('E'.$k_num, get_city_name($row['destination_city']));
        }
        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, get_city_name($row['destination_city']));
        $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['distance']);
        $is_metro=is_city_metro($row['destination_city']);
        $designation_id=get_user_deatils($userid)->user_designation_id;
        if($row['source_city']==$row['destination_city'])
        {
          
          if($row['distance']==1)
          {
            $this->excel->getActiveSheet()->setCellValue('F'.$k_num, 0);
            $this->excel->getActiveSheet()->setCellValue('G'.$k_num, 0);
            $row['ta']=0;
            $row['distance']=0;
          }
          else
          {
            $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['distance']);
            $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['ta']);
          }
         
        }
        else
        {
          if($row['ta']==0)
          {
            $this->excel->getActiveSheet()->setCellValue('G'.$k_num,"Actual Cost");
          }
          else
          {
            $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['ta']); 
          }
        }
        /*if($row['source_city']==$row['destination_city'])
        {
          $da=get_user_da(1,$designation_id,$is_metro);
        }*/
        $lenght= count($data['tada_report'])-1;
        $day= date('D',strtotime($row['doi']));
        if($key!=0 && $data['tada_report'][$key-1]['doi']==$row['doi'])
        {
          $da=0;
        }
        else
        {
          if($row['is_stay']==1 && $row['destination_city']==$lastdaydestination && $hqdistance>75)
          {
               $da=get_user_da(5,$designation_id,$is_metro);        
          }
          elseif($row['is_stay']==1 && $row['destination_city']!=$hq && $hqdistance>200)
          {
              $da=get_user_da(3,$designation_id,$is_metro); 
          }
          elseif($hqdistance>450 && $tpinfo)
          {
              $da=get_user_da(2,$designation_id,$is_metro); 
          }
          elseif($row['is_stay']==1 && $day=='Sat')
          {
              if($key==$lenght)
              {
                if($row['destination_city']!=$hq)
                {
                   $da=get_user_da(5,$designation_id,$is_metro)+get_user_da(2,$designation_id,$is_metro); 
                }
                else
                {
                   $da=get_user_da(1,$designation_id,$is_metro); 
                }
               
              }
              else
              {
                if(date('D',strtotime($data['tada_report'][$key+1]['doi']))=='Mon' && $data['tada_report'][$key+1]['destination_city']==$row['destination_city'])
                {
                  $da=get_user_da(5,$designation_id,$is_metro)+get_user_da(2,$designation_id,$is_metro);
                }
                else
                {
                  $da=get_user_da(5,$designation_id,$is_metro); 
                }
              }
          }
          else
          {
            $da=get_user_da(1,$designation_id,$is_metro); 
          }
        }
        if($key!=0 && $data['tada_report'][$key-1]['created_date']!=$row['created_date'])
        {
          $row['internet_charge']=0;
        }

        $totalrow=$row['ta']+$da+$row['internet_charge'];
        $this->excel->getActiveSheet()->setCellValue('H'.$k_num, $da);
        $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['internet_charge']);
        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $totalrow);
        if($row['up_down'])
        {
          $this->excel->getActiveSheet()->setCellValue('K'.$k_num, 'Back HO');
        }
        
        $gtrow=$gtrow+$totalrow;
       // $gtkms=$gtkms+$row['distance'];
        $gtta=$gtta+$row['ta'];
        $gtda=$gtda+$da;
        $gtpostage=$gtpostage+$row['internet_charge'];
        $k_num++;
      }
    }
     $k_num=$k_num+1;
     $this->excel->getActiveSheet()->getStyle('A'.$k_num.':K'.$k_num)->applyFromArray($styleArray);
     $this->excel->getActiveSheet()->getStyle('A'.$k_num.':K'.$k_num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
    $this->excel->getActiveSheet()->mergeCells('A'.$k_num.':D'.$k_num);
    $this->excel->getActiveSheet()->getStyle('A'.$k_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->setCellValue('A'.$k_num, 'Total');
    $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $gtta);
    $this->excel->getActiveSheet()->setCellValue('H'.$k_num, $gtda);
    $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $gtpostage);
    $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $gtrow);
    $k_num++;
    $extra=$k_num+1;
    $this->excel->getActiveSheet()->mergeCells('A'.$k_num.':D'.$extra);
    $this->excel->getActiveSheet()->getStyle('A'.$k_num.':A'.$extra)->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->getStyle('A'.$k_num)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $this->excel->getActiveSheet()->setCellValue('A'.$k_num, 'Total Payable Amount :- Rs. '.$gtrow);

    $k_num++;
    $extra=$k_num+1;
    $less=$k_num-1;
    $this->excel->getActiveSheet()->mergeCells('E'.$less.':H'.$extra);
    $this->excel->getActiveSheet()->mergeCells('I'.$less.':K'.$less);
    $this->excel->getActiveSheet()->setCellValue('I'.$less, 'Received On');
    $this->excel->getActiveSheet()->mergeCells('I'.$k_num.':K'.$k_num);
    $this->excel->getActiveSheet()->setCellValue('I'.$k_num, 'Checked By');
    $k=$k_num+1;
    $this->excel->getActiveSheet()->mergeCells('A'.$k.':D'.$extra);
    $this->excel->getActiveSheet()->mergeCells('I'.$k.':K'.$k);
    $this->excel->getActiveSheet()->setCellValue('I'.$k, 'Passed By');
    $this->excel->getActiveSheet()->setCellValue('A'.$extra, 'Total No. of Vouchers.');
    $this->excel->getActiveSheet()->getStyle('E'.$less)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $this->excel->getActiveSheet()->getStyle('E'.$less)->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('E'.$less, 'For the HO use only.');
    $styleArray1 = array(
      'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $this->excel->getActiveSheet()->getStyle("A1:K".$extra)->applyFromArray($styleArray1);
    $name=preg_replace('/\s+/', '', ucfirst(get_user_name($userid)));
    $filename=$name.'_TADA_Report.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    //ob_end_clean();
    //ob_start();
    $objWriter->save('php://output');
}


  public function cust_relationship(){



       $request = $this->input->post();



      if(!empty($request)){

      //       pr($request); die;

      $report_date = explode('-',$request['report_date'] );

      $followstart_date =  trim($report_date[0]);

      $newstartdate = str_replace('/', '-', $followstart_date);

      //  echo $newstartdate;

      $followend_date =  trim($report_date[1]);

      $newenddate = str_replace('/', '-', $followend_date);

      $start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";

      $end = date('Y-m-d', strtotime($newenddate))." 23:59:59";

      $this->load->library('form_validation');

        /*if(!($request['dealer_id']=='' && $request['pharma_id']=='')&&($request['dealer_id']=='' || $request['pharma_id']==''))

        {
*/
          if(isset($request['dealer_id'])){

            $this->relationship_report_dealer($request['dealer_id'],$start,$end); 

          }

          if(isset($request['pharma_id'])){

            $this->relationship_report_pharma($request['pharma_id'],$start,$end);  

          }

       /* }

        else

        {

          set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>Please select dealer or pharmacy but not both at the same time.!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

        }*/

     

         /*if(empty($request['dealer_id']) && empty($request['pharma_id'])){

         $this->form_validation->set_rules('dealer_id', 'Dealer', 'required');

         $this->form_validation->set_rules('pharma_id', 'Pharmacy', 'required');

        }

         else{

             $this->form_validation->set_rules('report_date', 'Report Date range', 'required');

         }*/



        }

       else{

            redirect($_SERVER['HTTP_REFERER']);

        }

    }





    public function sale_travel(){

    $request = $this->input->post();

    if(!empty($request)){





    $report_date = explode('-',$request['report_date'] );





    $followstart_date =  trim($report_date[0]);





    $newstartdate = str_replace('/', '-', $followstart_date);





    //         echo $newstartdate;





    $followend_date =  trim($report_date[1]);





    $newenddate = str_replace('/', '-', $followend_date);











    //         pr($report_date); 





    $start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";





    $end = date('Y-m-d', strtotime($newenddate))." 23:59:59";





    //           echo $end."<br>";





    //         echo $start; die;





    $this->load->library('form_validation');





    $this->form_validation->set_rules('user_id', 'User', 'required');





    $this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 





    $this->form_validation->set_rules('r1', 'Report Type', 'required'); 





    if($this->form_validation->run() == TRUE){





    if($request['r1']=="sales"){





    $this->sale_report($request['user_id'],$start,$end);





         }





         if($request['r1']=="travel"){





            $this->travel_report($request['user_id'],$start,$end);  





         }





            





         





         }else{





              // for false validation





             $this->index();  





            }





          }





          else{





             redirect('admin_control/report'); 





          }







            





//         pr($report_date);





//         pr(date('m-d-Y', strtotime($report_date[0]))); die;





    }











    











    // Customer Relationship Report  





    public function relationship_report_dealer($dealer_id,$start,$end)





    {











                $this->excel->setActiveSheetIndex(0);





                //name the worksheet





                $this->excel->getActiveSheet()->setTitle('Relationship Report');





                //set cell A1 content with some text





                $this->excel->getActiveSheet()->setCellValue('A1', 'Date');





                $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');





                $this->excel->getActiveSheet()->setCellValue('C1', 'City');





                $this->excel->getActiveSheet()->setCellValue('D1', 'Type');





                $this->excel->getActiveSheet()->setCellValue('E1', 'User');            





                $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');





                $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');





                $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');





                $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');          





                $this->excel->getActiveSheet()->setCellValue('J1', 'Secondary Sale');





 





                





                $data['rr_dealer'] =$this->report->relationship_report_dealer($dealer_id,$start,$end); // for Dealer





              





                 $k_num=2;





                 $total_secondary_sale=0;





                 if(!empty($data['rr_dealer']['dealer_info'])){





        foreach ( $data['rr_dealer']['dealer_info'] as $k=>$row){   // for Dealer information 





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y', strtotime($row['date'])) );





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);





              if(empty($row['is_cf'])){





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Dealer');





              }





              else{





                  $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'C & F'); 





              }





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);





             





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num,$row['sale']);





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['payment']);





              $this->excel->getActiveSheet()->setCellValue('H'.$k_num, date('d.m.Y', strtotime($row['date'])));





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['stock']);





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num, '');





              





              $total_secondary_sale += $row['sale'];





              





             $k_num++;





              





        }





                 





        $total_positon = count($data['rr_dealer']['dealer_info'])+2;





        $this->excel->getActiveSheet()->setCellValue('B'.$total_positon, 'TOTAL');





        $this->excel->getActiveSheet()->setCellValue('F'.$total_positon, 'Rs.'.$total_secondary_sale);





        $this->excel->getActiveSheet()->getStyle('B'.$total_positon)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('F'.$total_positon)->getFont()->setBold(true);





                 }





//        $this->excel->getActiveSheet()->getStyle()->getBorders()->getBottom()->setBorderStyle($total_positon,PHPExcel_Style_Border::BORDER_THIN);











       





        $k_num_int = count($data['rr_dealer']['dealer_info'])+4;





        $total_secondary_sale_doc=0;





        if(!empty($data['rr_dealer']['dealer_doc_relation'])){





 foreach ( $data['rr_dealer']['dealer_doc_relation'] as $k_doc=>$row_doc){   // for Doctor information 





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Doctor');





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);





             





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);





              





              $total_secondary_sale_doc += $row_doc['secondary_sale'];





              





             $k_num_int++;





              





        }    





    }





       if(!empty($data['rr_dealer']['dealer_pharma_relation'])){





        foreach ( $data['rr_dealer']['dealer_pharma_relation'] as $k_doc=>$row_doc){   // for dealer pharmacy relation





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Pharmacy');





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);





             





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);





              





              $total_secondary_sale_doc += $row_doc['secondary_sale'];





              





             $k_num_int++;





              





        }





       }





        





        





        





        $total_positon_doc = count($data['rr_dealer']['dealer_pharma_relation'])+count($data['rr_dealer']['dealer_info'])+count($data['rr_dealer']['dealer_doc_relation'])+6;





        $this->excel->getActiveSheet()->setCellValue('B'.$total_positon_doc, 'TOTAL');





        $this->excel->getActiveSheet()->setCellValue('J'.$total_positon_doc, 'Rs.'.$total_secondary_sale_doc);





        $this->excel->getActiveSheet()->getStyle('B'.$total_positon_doc)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('J'.$total_positon_doc)->getFont()->setBold(true);





         





         $relationship_percentage =  $total_positon_doc+2;





         if($total_secondary_sale!=0){





         $result_pecentage = ($total_secondary_sale_doc/$total_secondary_sale)*100 ;





         }





         else{





           $result_pecentage=0;  





         }





         $this->excel->getActiveSheet()->setCellValue('A'.$relationship_percentage,'B. Jain Contribution' );





         $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,$result_pecentage.'%' );





          





        $this->excel->getActiveSheet()->getStyle('A'.$relationship_percentage)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('B'.$relationship_percentage)->getFont()->setBold(true);





//           $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,'=' );





         





//                //Fill data 





//                $this->excel->getActiveSheet()->fromArray($customerdata,'A2');





                 





                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                 





                $filename='DealerReportCard.xls'; //save our workbook as this file name





                header('Content-Type: application/vnd.ms-excel'); //mime type





                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name





                header('Cache-Control: max-age=0'); //no cache





 





                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)





                //if you want to save it as .XLSX Excel 2007 format





                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  





                //force user to download the Excel file without writing it to server's HD



              //ob_end_clean();

              //ob_start();

              $objWriter->save('php://output');





                 





    }





    





    





    





    public function relationship_report_pharma($pharma_id,$start,$end)





    {











                $this->excel->setActiveSheetIndex(0);





                //name the worksheet





                $this->excel->getActiveSheet()->setTitle('Relationship Report');





                //set cell A1 content with some text





                $this->excel->getActiveSheet()->setCellValue('A1', 'Date');





                $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');





                $this->excel->getActiveSheet()->setCellValue('C1', 'City');





                $this->excel->getActiveSheet()->setCellValue('D1', 'Type');





                $this->excel->getActiveSheet()->setCellValue('E1', 'User');            





                $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');





                $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');





                $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');





                $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');          





                $this->excel->getActiveSheet()->setCellValue('J1', 'Secondary Sale');





 





                





                $data['rr_pharmacy'] =$this->report->relationship_report_pharmacy($pharma_id,$start,$end); // for Pharmacy





              





                 $k_num=2;





                 $total_secondary_sale=0;





                 if(!empty($data['rr_pharmacy']['pharmacy_info'])){





        foreach ( $data['rr_pharmacy']['pharmacy_info'] as $k=>$row){   // for Pharmacy information 





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y', strtotime($row['date'])) );





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Pharmacy');





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);





             





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num,'');





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num, '');





              $this->excel->getActiveSheet()->setCellValue('H'.$k_num, '');





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num, '');





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['secondary_sale']);





              





              $total_secondary_sale += $row['secondary_sale'];





              





             $k_num++;





              





        }    





        $total_positon = count($data['rr_pharmacy']['pharmacy_info'])+2;





        $this->excel->getActiveSheet()->setCellValue('B'.$total_positon, 'TOTAL');





        $this->excel->getActiveSheet()->setCellValue('J'.$total_positon, 'Rs.'.$total_secondary_sale);





        $this->excel->getActiveSheet()->getStyle('B'.$total_positon)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('J'.$total_positon)->getFont()->setBold(true);





                 }





//        $this->excel->getActiveSheet()->getStyle()->getBorders()->getBottom()->setBorderStyle($total_positon,PHPExcel_Style_Border::BORDER_THIN);











       





        $k_num_int = count($data['rr_pharmacy']['pharmacy_info'])+4;





        $total_secondary_sale_doc=0;





        if(!empty($data['rr_pharmacy']['pharma_doc_relation'])){





 foreach ( $data['rr_pharmacy']['pharma_doc_relation'] as $k_doc=>$row_doc){   // for Doctor information 





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Doctor');





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);





             





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);





              





              $total_secondary_sale_doc += $row_doc['secondary_sale'];





              





             $k_num_int++;





              





        }





        }





        $total_positon_doc = count($data['rr_pharmacy']['pharmacy_info'])+count($data['rr_pharmacy']['pharma_doc_relation'])+6;





        $this->excel->getActiveSheet()->setCellValue('B'.$total_positon_doc, 'TOTAL');





        $this->excel->getActiveSheet()->setCellValue('J'.$total_positon_doc, 'Rs.'.$total_secondary_sale_doc);





        $this->excel->getActiveSheet()->getStyle('B'.$total_positon_doc)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('J'.$total_positon_doc)->getFont()->setBold(true);





         





        $relationship_percentage =  $total_positon_doc+2;





        if($total_secondary_sale !=0){





         $result_pecentage = ($total_secondary_sale_doc/$total_secondary_sale)*100 ;





        }





        else{





            $result_pecentage=0;





        }





         $this->excel->getActiveSheet()->setCellValue('A'.$relationship_percentage,'B. Jain Contribution' );





         $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,$result_pecentage.'%' );





          





        $this->excel->getActiveSheet()->getStyle('A'.$relationship_percentage)->getFont()->setBold(true);





        $this->excel->getActiveSheet()->getStyle('B'.$relationship_percentage)->getFont()->setBold(true);





        





        





//           $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,'=' );





         





//                //Fill data 





//                $this->excel->getActiveSheet()->fromArray($customerdata,'A2');





                 





                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                 





                $filename='PharmacyReportCard.xls'; //save our workbook as this file name





                header('Content-Type: application/vnd.ms-excel'); //mime type





                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name





                header('Cache-Control: max-age=0'); //no cache





 





                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)





                //if you want to save it as .XLSX Excel 2007 format





                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  





                //force user to download the Excel file without writing it to server's HD



              //ob_end_clean();

              //ob_start();

                $objWriter->save('php://output');





                 





    }



    // Travel Report 





     public function travel_report($userid,$start,$end)





    {





        





                $this->excel->setActiveSheetIndex(0);





                //name the worksheet





                $this->excel->getActiveSheet()->setTitle('Travel Report');





                //set cell A1 content with some text





                $this->excel->getActiveSheet()->setCellValue('A1', 'Date');





                $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');





                $this->excel->getActiveSheet()->setCellValue('C1', 'City');





                $this->excel->getActiveSheet()->setCellValue('D1', 'Type');





                $this->excel->getActiveSheet()->setCellValue('E1', 'User');





//                $this->excel->getActiveSheet()->setCellValue('E1', 'Total Visits');





                $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');





                $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');





//                $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');





                $this->excel->getActiveSheet()->setCellValue('H1', 'Stock');





                $this->excel->getActiveSheet()->setCellValue('I1', 'Sample');





                $this->excel->getActiveSheet()->setCellValue('J1', 'Met');





                $this->excel->getActiveSheet()->setCellValue('K1', 'Not Met');





                $this->excel->getActiveSheet()->setCellValue('L1', 'Secondary Sale');





                $this->excel->getActiveSheet()->setCellValue('M1', 'Orignal Supply Value');





                $this->excel->getActiveSheet()->setCellValue('N1', 'Date of Supply');





                $this->excel->getActiveSheet()->setCellValue('O1', 'Remarks');





                $this->excel->getActiveSheet()->setCellValue('P1', 'Joint Working');





                $this->excel->getActiveSheet()->setCellValue('Q1', 'Telephonic');





                





                $data['travel'] =$this->report->travel_report_doctor($userid,$start,$end); // for doctor





              





                 $k_num=2;





                 if(!empty($data['travel']['doc_info'])){





        foreach ( $data['travel']['doc_info'] as $k=>$row){   // for doctor information with sample





              





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Doctor');





//               if($row['user']!=NULL){





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);





//              }





              





//              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);





               if($row['metnotmet']==TRUE ){





                   





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['metnotmet']);





             }





             if($row['metnotmet']==FALSE && $row['metnotmet']!=NULL ){





                 





              $this->excel->getActiveSheet()->setCellValue('K'.$k_num,1);





             }





              





             $this->excel->getActiveSheet()->setCellValue('L'.$k_num, $row['secondary_sale']);





             $this->excel->getActiveSheet()->setCellValue('M'.$k_num, $row['order_supply']);





             if($row['date_of_supply'] != NULL){





             $this->excel->getActiveSheet()->setCellValue('N'.$k_num, date('d.m.Y', strtotime($row['date_of_supply'])));





             }





              $this->excel->getActiveSheet()->setCellValue('O'.$k_num, $row['remark']);





              $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);





             $k_num++;





              





        }





        $k_num_team=2;





        foreach($data['travel']['team_info'] as $k_team=>$row_team){





            





              $this->excel->getActiveSheet()->setCellValue('P'.$k_num_team, $row_team['team_user']);





              





               $k_num_team++;





        }





        





                 }





        





          $data['travel_dealer'] =$this->report->travel_report_dealer($userid,$start,$end);   // for dealer





          





                  $k_num= count($data['travel']['doc_info'])+2;





                  





                  if(!empty($data['travel_dealer']['dealer_info'])){





        foreach ( $data['travel_dealer']['dealer_info'] as $k=>$row){   // for dealer information with sample





             $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);





              if(empty($row['is_cf'])){





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Dealer');





              }





              else{





                  $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'C & F'); 





              }





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']); 





            





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['sale']);





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['payment']);





              





               $this->excel->getActiveSheet()->setCellValue('H'.$k_num, $row['stock']);





               $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);





//                $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['stock']);





                if($row['metnotmet']==TRUE ){





                   





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['metnotmet']);





             }





             if($row['metnotmet']==FALSE && $row['metnotmet']!=NULL ){





              $this->excel->getActiveSheet()->setCellValue('K'.$k_num, 1);





             }





             $this->excel->getActiveSheet()->setCellValue('O'.$k_num, $row['remark']);





             $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);





              





              $k_num++;         





        }





        





        $k_num_team=count($data['travel']['doc_info'])+2;





        foreach($data['travel_dealer']['team_info'] as $k_team=>$row_team){





            





              $this->excel->getActiveSheet()->setCellValue('P'.$k_num_team, $row_team['team_user']);





              





               $k_num_team++;





        }





        





        





                  }  





        





         $data['travel_pharmacy'] =$this->report->travel_report_pharmacy($userid,$start,$end);   // for pharmacy





          





                  $k_num= count($data['travel_dealer']['dealer_info'])+ count($data['travel']['doc_info'])+2;





                 





                  if(!empty($data['travel_pharmacy']['pharmacy_info'])){





        foreach ( $data['travel_pharmacy']['pharmacy_info'] as $k=>$row){   // for pharmacy information with sample





          





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Pharmacy');





//              if($row['user']!=NULL){





              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);





//              }





//              else{





//                  $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['team_user']);





//                  





//              }





//              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);





              $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);





               if($row['metnotmet']==TRUE ){





                   





              $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['metnotmet']);





             }





             if($row['metnotmet']==FALSE && $row['metnotmet']!=NULL ){





              $this->excel->getActiveSheet()->setCellValue('K'.$k_num, 1);





             }





              





             $this->excel->getActiveSheet()->setCellValue('L'.$k_num, $row['secondary_sale']);





             $this->excel->getActiveSheet()->setCellValue('M'.$k_num, $row['order_supply']);





             if($row['date_of_supply'] != NULL){





             $this->excel->getActiveSheet()->setCellValue('N'.$k_num, date('d.m.Y', strtotime($row['date_of_supply'])));





             }





             $this->excel->getActiveSheet()->setCellValue('O'.$k_num, $row['remark']);





             $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);





              





              $k_num++;





              





          }   





          





           $k_num_team=count($data['travel_dealer']['dealer_info'])+ count($data['travel']['doc_info'])+2;





        foreach($data['travel_pharmacy']['team_info'] as $k_team=>$row_team){





            





              $this->excel->getActiveSheet()->setCellValue('P'.$k_num_team, $row_team['team_user']);





              





               $k_num_team++;





        }





          





          





            }





       





//                //Fill data 





//                $this->excel->getActiveSheet()->fromArray($customerdata,'A2');





                 





                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





                 





                $filename='TravelReportUser.xls'; //save our workbook as this file name





                header('Content-Type: application/vnd.ms-excel'); //mime type





                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name





                header('Cache-Control: max-age=0'); //no cache





 





                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)





                //if you want to save it as .XLSX Excel 2007 format





                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  





                //force user to download the Excel file without writing it to server's HD



       //ob_end_clean ();

        //ob_start();

                $objWriter->save('php://output');





                 





    }





    





    // sale report





    public function sale_report($userid,$start,$end)





    {

        $primarySale=0;

        $secondarySale=0;

        $duplicateSale=0;

        $payment=0;

        $totVisit=0;

        $docMeet=0;

        $k_num_int=0;

        $pharmaMeet=0;





            $docNo = $this->report->all_user_doctor($userid);

            $pharmaNo = $this->report->all_user_pharma($userid);

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('Sale Report');

            //set cell A1 content with some text

            $this->excel->getActiveSheet()->setCellValue('A1', 'Customer');

            $this->excel->getActiveSheet()->setCellValue('B1', 'City');

            $this->excel->getActiveSheet()->setCellValue('C1', 'Type');

            $this->excel->getActiveSheet()->setCellValue('D1', 'User');

            $this->excel->getActiveSheet()->setCellValue('E1', 'Total Visits');

            $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');

            $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');

            $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');

            $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');

            $this->excel->getActiveSheet()->setCellValue('J1', 'Sample');

            $this->excel->getActiveSheet()->setCellValue('K1', 'Met');

            $this->excel->getActiveSheet()->setCellValue('L1', 'Not Met');

            $this->excel->getActiveSheet()->setCellValue('M1', 'Secondary Sale');

            $this->excel->getActiveSheet()->setCellValue('N1', 'Duplicate Secondary');

            $this->excel->getActiveSheet()->setCellValue('O1', 'Duplicate Product');

            $this->excel->getActiveSheet()->setCellValue('P1', 'Duplicate Secondary Customer');

            //$this->excel->getActiveSheet()->setCellValue('P1', 'Duplicate Secondary Person Type');

            $data['sale'] =$this->report->sale_report_doctor($userid,$start,$end); // for doctor

            $k_num=2;

            if(!empty($data['sale']['doc_info'])){

            foreach ( $data['sale']['doc_info'] as $k=>$row){   // for doctor information with sample

            $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);

            $docMeet++;

            $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);

            $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Doctor');

            $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);

            //$this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);

            $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);

            $k_num++;

        }    





        $k_num_int = 2;





        foreach ( $data['sale']['doc_interaction'] as $k_doc=>$row_doc){  // for doctor total visit,secondry sale,met,not met

          $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);

          $totVisit=$totVisit+$row_doc['total_visits'];

          $met=$row_doc['met']==0?'No':'Yes';

          $notmet=$row_doc['notmet']==0?'No':'Yes';

          $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);

          $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);

          /*$this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['met']);

          $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $row_doc['notmet']);*/

          $this->excel->getActiveSheet()->setCellValue('M'.$k_num_int, $row_doc['secondary_sale']);

          $secondarySale=$secondarySale+$row_doc['secondary_sale'];

          $k_num_int++;

        }





      }





        





          $data['sale_dealer'] =$this->report->sale_report_dealer($userid,$start,$end);   // for dealer





          





                  $k_num= count($data['sale']['doc_info'])+2;





               if(!empty($data['sale_dealer']['dealer_info'])){   





        foreach ( $data['sale_dealer']['dealer_info'] as $k=>$row){   // for dealer information with sample





              $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);





              $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);





              if(empty($row['is_cf'])){





              $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Dealer');





              }





              else{





                  $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'C & F'); 





              }





              





              $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);





               $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);





//              $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);





              $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['sale']);

        $primarySale=$primarySale+$row['sale'];





              $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['Payment']);





              $payment=$payment+$row['Payment'];





              $k_num++;





              





        }    





        $k_num_int = count($data['sale']['doc_info'])+2;





        foreach ( $data['sale_dealer']['dealer_interaction'] as $k_doc=>$row_doc){  // for dealer total visit,secondry sale,met,not met





              





            if(!empty($row_doc['stock_date'])){  

                $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int,date('d.m.Y',strtotime($row_doc['stock_date'])) );

            }

              $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $row_doc['stock']);

              $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);

              $totVisit=$totVisit+$row_doc['total_visits'];

              $met=$row_doc['met']==0?'No':'Yes';

              $notmet=$row_doc['notmet']==0?'No':'Yes';

              $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);

              $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);

//              $this->excel->getActiveSheet()->setCellValue('N'.$k_num_int, $row_doc['duplicate_secondary']);

              $k_num_int++;

    }





               }



        $data['sale_pharmacy'] =$this->report->sale_report_pharmacy($userid,$start,$end);   // for pharmacy

        $k_num= count($data['sale_dealer']['dealer_info'])+ count($data['sale']['doc_info'])+2;

        if(!empty($data['sale_pharmacy']['pharmacy_info'])){

            foreach ( $data['sale_pharmacy']['pharmacy_info'] as $k=>$row){   // for pharmacy information with sample

                $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);

                $pharmaMeet++;

                $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);

                $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Pharmacy');

                $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);

                $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);

                $k_num++;

            }    

          $k_num_int = count($data['sale_dealer']['dealer_info'])+ count($data['sale']['doc_info'])+2;

          foreach ( $data['sale_pharmacy']['pharmacy_interaction'] as $k_doc=>$row_doc){  // for pharmacy total visit,secondry sale,met,not met

            $productDuplicate='';

            $docDuplicate='';

            $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);

            $totVisit=$totVisit+$row_doc['total_visits'];

            $met=$row_doc['met']==0?'No':'Yes';

            $notmet=$row_doc['notmet']==0?'No':'Yes';

            //echo $row_doc['duplicate_product'];

            $product=explode(',',$row_doc['duplicate_product']);

            $proDeatils=array_unique(array_filter($product));

            foreach($proDeatils as $proid)

            {

              $prodetl=get_product_name($proid).'('.get_packsize_name($proid).')';

              if($productDuplicate=='')

              {

                $productDuplicate=$prodetl;

              }

              else

              {

                $productDuplicate=$productDuplicate.','.$prodetl;

              }

              

            }



            $docDetails=explode(',',$row_doc['dup_doctor_id']);

            $dupdocDetails=array_unique(array_filter($docDetails));

            foreach($dupdocDetails as $doc)

            {

              $docdetl=get_doctor_name($doc);

              if($docDuplicate=='')

              {

                $docDuplicate=$docdetl;

              }

              else

              {

                $docDuplicate=$docDuplicate.','.$docdetl;

              }

              

            }

            $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);

            $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);

            /* $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['met']);

            $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $row_doc['notmet']);*/

            $this->excel->getActiveSheet()->setCellValue('M'.$k_num_int, $row_doc['secondary_sale']);

            $secondarySale=$secondarySale+$row_doc['secondary_sale'];

            $this->excel->getActiveSheet()->setCellValue('N'.$k_num_int, $row_doc['duplicate_secondary']);

            $this->excel->getActiveSheet()->setCellValue('O'.$k_num_int, $productDuplicate);

            $this->excel->getActiveSheet()->setCellValue('P'.$k_num_int, $docDuplicate);

            $duplicateSale=$duplicateSale+$row_doc['duplicate_secondary']; 

            $k_num_int++;

          }

        }

        

      $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int, $primarySale);

      $this->excel->getActiveSheet()->setCellValue('M'.$k_num_int, $secondarySale);

      $this->excel->getActiveSheet()->setCellValue('N'.$k_num_int, $duplicateSale);

      $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, $payment);

      $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $totVisit);

      $k_num_int=$k_num_int+3;

      $docNo = $this->report->all_user_doctor($userid);

      $pharmaNo = $this->report->all_user_pharma($userid);



      $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Total Doctor');

      $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docNo);

      $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Total Pharmacy');

      $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaNo);

      $k_num_int++;

      $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Met Doctor');

      $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docMeet);

      $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Met Pharmacy');

      $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaMeet);

      $k_num_int++;

      $docMissed=$docNo-$docMeet;

      $pharmaMissed=$pharmaNo-$pharmaMeet;

      $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Missed Doctor');

      $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docMissed);

      $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Missed Pharmacy');

      $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaMissed);

      // Fill data 

      // $this->excel->getActiveSheet()->fromArray($customerdata,'A2');

      $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $filename='SaleReportUser.xls'; //save our workbook as this file name

      header('Content-Type: application/vnd.ms-excel'); //mime type

      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

      header('Cache-Control: max-age=0'); //no cache

      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

      //if you want to save it as .XLSX Excel 2007 format

      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  

      //force user to download the Excel file without writing it to server's HD

      //ob_end_clean();

      //ob_start();

      $objWriter->save('php://output');

    }

}

?>
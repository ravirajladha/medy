<?php
class Pharmacy
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function save_drug($drug_name, $drug_gen, $drug_manf, $drug_form, $drug_unit_dosage, $min_drg_pack)
    {
        $this->db->query('INSERT INTO drugs (drug_name, gen_name, drug_manufacturer, drug_formulation, drug_dossage, drug_package) VALUES (:drug_name, :drug_gen, :drug_manf, :drug_form, :drug_unit_dosage, :min_drg_pack)');
        $this->db->bind(':drug_name', $drug_name);
        $this->db->bind(':drug_gen', $drug_gen);
        $this->db->bind(':drug_manf', $drug_manf);
        $this->db->bind(':drug_form', $drug_form);
        $this->db->bind(':drug_unit_dosage', $drug_unit_dosage);
        $this->db->bind(':min_drg_pack', $min_drg_pack);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function update_drug($drug_name, $drug_gen, $drug_manf, $drug_form, $drug_unit_dosage, $min_drg_pack, $ch)
    {
        $this->db->query('UPDATE drugs SET drug_name = :drug_name, gen_name = :drug_gen, drug_manufacturer = :drug_manf, drug_formulation = :drug_form, drug_dossage = :drug_unit_dosage, drug_package = :min_drg_pack WHERE drug_id = :ch');
        $this->db->bind(':drug_name', $drug_name);
        $this->db->bind(':drug_gen', $drug_gen);
        $this->db->bind(':drug_manf', $drug_manf);
        $this->db->bind(':drug_form', $drug_form);
        $this->db->bind(':drug_unit_dosage', $drug_unit_dosage);
        $this->db->bind(':min_drg_pack', $min_drg_pack);
        $this->db->bind(':ch', $ch);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // public function auto_drug_name($cust)
 //    {
    //  $this->db->query("SELECT DISTINCT stocks.drug_id,drugs.drug_id, drugs.drug_name FROM stocks INNER JOIN drugs ON stocks.drug_id = drugs.drug_id AND (drugs.drug_name LIKE concat('%', :cust, '%') OR drugs.drug_id LIKE concat('%', :cust, '%')) LIMIT 10");
    //  $this->db->bind(':cust',$cust);
    //  $row = $this->db->resultSet();
    //  return $row;
 //    }

    public function auto_drug_name($cust)
    {
        $this->db->query("SELECT DISTINCT * FROM drugs WHERE drug_name LIKE concat('%', :cust, '%') OR drug_id LIKE concat('%', :cust, '%') LIMIT 10");
        $this->db->bind(':cust',$cust);
        $row = $this->db->resultSet();
        return $row;
    }

    public function auto_dist_name($cust)
    {
        $this->db->query("SELECT DISTINCT stock_distributor FROM stocks WHERE stock_distributor LIKE concat('%', :cust, '%')");
        $this->db->bind(':cust',$cust);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_drugs($lim,$off,$filter)
    {
        if($filter == 1)
        {
            $this->db->query('SELECT * FROM drugs ORDER BY drug_id DESC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 2) 
        {
            $this->db->query('SELECT * FROM drugs ORDER BY drug_name ASC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 3) 
        {
            $this->db->query('SELECT * FROM drugs ORDER BY drug_name DESC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 4) 
        {
            $this->db->query('SELECT * FROM drugs ORDER BY drug_id ASC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        else
        {
            $this->db->query('SELECT * FROM drugs WHERE drug_name LIKE concat(:filter, "%") limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $this->db->bind(':filter', $filter);
            $row = $this->db->resultSet();
            return $row;

        }
    }

    public function get_all_drugs_az($lim,$off)
    {
        $this->db->query('SELECT * FROM drugs ORDER BY drug_name ASC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

     public function get_batch_using_id($a)
    {
        $this->db->query('SELECT * FROM stocks WHERE drug_id = :a');
        $this->db->bind(':a',$a);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_drug_details($id)
    {
        $this->db->query('SELECT * FROM drugs WHERE drug_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_stock_details($id)
    {
        $this->db->query('SELECT * FROM stocks WHERE stock_batch = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_stock_detailsx($id)
    {
        $this->db->query('SELECT * FROM stocks WHERE drug_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function remove_drug_db($drug_id)
    {
        $this->db->query('DELETE FROM drugs WHERE drug_id = :drug_id');
        $this->db->bind(':drug_id', $drug_id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save_batch_data($drug_id, $drug_identity, $drug_batch, $drug_exp_mth, $drug_exp_yr, $drug_stck, $dist, $drug_cgst, $drug_sgst, $drug_buy, $drug_sell)
    {
        $drug_exp = $drug_exp_mth;
        $drug_exp .= " - ";
        $drug_exp .= $drug_exp_yr;
        $drug_buy=number_format((float)$drug_buy, 2, '.', '');
        $drug_sell=number_format((float)$drug_sell, 2, '.', '');
        $drug_cgst=number_format((float)$drug_cgst, 2, '.', '');
        $drug_sgst=number_format((float)$drug_sgst, 2, '.', '');
        $drug_taxable_amount=($drug_sell*100)/(100+$drug_cgst+$drug_sgst);
        $drug_taxable_amount=number_format((float)$drug_taxable_amount, 2, '.', '');
        $dat = date('Y-m-d');
        $this->db->query('INSERT INTO stocks (drug_id, stock_quant, stock_batch, stock_expiry, stock_distributor, drug_cgst, drug_sgst, drug_taxable_amount, drug_buy_cost, drug_sell_cost, stock_total, stock_date) VALUES(:drug_id, :drug_stck, :drug_batch, :drug_exp, :dist, :drug_cgst, :drug_sgst, :drug_taxable_amount, :drug_buy, :drug_sell, :drug_stck, :dat)');
        $this->db->bind(':drug_id', $drug_id);
        $this->db->bind(':drug_stck', $drug_stck);
        $this->db->bind(':drug_batch', $drug_batch);
        $this->db->bind(':drug_exp', $drug_exp);
        $this->db->bind(':dist', $dist);
        $this->db->bind(':drug_sgst', $drug_sgst);
        $this->db->bind(':drug_cgst', $drug_cgst);
        $this->db->bind(':drug_taxable_amount', $drug_taxable_amount);
        $this->db->bind(':drug_buy', $drug_buy);
        $this->db->bind(':drug_sell', $drug_sell);
        $this->db->bind(':drug_stck', $drug_stck);
        $this->db->bind(':dat', $dat);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_all_purchase($lim,$off,$filter)
    {
        if($filter == 1)
        {
            $this->db->query('SELECT * FROM stocks ORDER BY stock_id DESC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 2) 
        {
            $this->db->query('SELECT * FROM stocks ORDER BY stock_date ASC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 3) 
        {
            $this->db->query('SELECT * FROM stocks ORDER BY stock_quant ASC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        elseif ($filter == 4) 
        {
            $this->db->query('SELECT * FROM stocks ORDER BY stock_expiry DESC limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $row = $this->db->resultSet();
            return $row;
        }

        else
        {
            $this->db->query('SELECT drugs.drug_name, drugs.drug_id, stocks.stock_quant, stocks.stock_expiry, stocks.stock_batch, stocks.stock_date FROM drugs INNER JOIN stocks ON drugs.drug_id = stocks.drug_id AND drugs.drug_name LIKE concat(:filter, "%") limit :lim OFFSET :off');
            $this->db->bind(':lim',$lim);
            $this->db->bind(':off',$off);
            $this->db->bind(':filter', $filter);
            $row = $this->db->resultSet();
            return $row;

        }
    }

    public function get_drug_name($id)
    {
        $this->db->query('SELECT drug_name FROM drugs WHERE drug_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }


    public function get_all_orders($lim,$off)
    {
        $this->db->query('SELECT * FROM invoice_pharms ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_orders_request($lim,$off)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_status = 1 ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_invoice_by_id($id)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_manf_name_db($id)
    {
        $this->db->query('SELECT drug_manufacturer FROM drugs WHERE drug_id =:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function get_drugname_db($id)
    {
        $this->db->query('SELECT drug_name FROM drugs WHERE drug_id =:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function cancel_invoice_db($drug_id)
    {
        $this->db->query('UPDATE invoice_pharms SET cancelled = 1 WHERE invoice_id = :drug_id');
        $this->db->bind(':drug_id', $drug_id);
        $row = $this->db->execute();
        if($row)
            return true;
        else
            return false;
    }

    public function get_cost($aamt)
    {
        $this->db->query('SELECT * FROM stocks WHERE stock_batch = :aamt AND stock_quant > 0');
        $this->db->bind(':aamt', $aamt);
        $row = $this->db->resultSet();
        return $row;
    }


    public function get_batch_name($aamt)
    {
        $this->db->query('SELECT stock_batch FROM stocks WHERE drug_id = :aamt AND stock_quant > 0');
        $this->db->bind(':aamt', $aamt);
        $row = $this->db->resultSet();
        return $row;
    }

    public function save_invoice_db_edit($service_id, $bat, $invoice_bill, $grand_total, $patient_name, $doctor_name, $ipopid, $pay_mode, $amount_paid, $discount,$id)
    {
        $patient_name1 = explode('|', $patient_name);
        $patient_name = $patient_name1[0];
        $doctor_name1 = explode('|', $doctor_name);
        $doctor_name = $doctor_name1[0];
        $this->db->query('UPDATE invoice_pharms SET invoice_name = :patient_name, invoice_doctor = :doctor_name, invoice_items = :service_id, items_batch = :bat, invoice_total =:grand_total, payment = :pay_mode, paid = :amount_paid, discount = :discount,  invoice_status = "2" WHERE invoice_id = :id');
        $this->db->bind(':patient_name', $patient_name);
        $this->db->bind(':doctor_name', $doctor_name);
        $this->db->bind(':service_id', $service_id);
        $this->db->bind(':bat', $bat);
        $this->db->bind(':grand_total', $grand_total);
        $this->db->bind(':pay_mode', $pay_mode);
        $this->db->bind(':amount_paid', $amount_paid);
        $this->db->bind(':discount', $discount);
        $this->db->bind(':id', $id);
        if($this->db->execute())
        {
            $service_id = explode(',', $service_id);
            $bat = explode(',', $bat);
            for ($i=0,$j=0; $i < sizeof($service_id)-1; $i=$i+2, $j++)
            { 
                $drug_id = $service_id[$i];
                $drug_qty = $service_id[$i+1];
                $batch = $bat[$i];
                $this->db->query('UPDATE stocks SET stock_quant = stock_quant - :drug_qty WHERE drug_id  = :drug_id AND stock_batch = :batch');
                $this->db->bind(':drug_qty', $drug_qty);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':drug_id', $drug_id);
                if($this->db->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }            
        }
        else
        {
            return false;
        }
    }

    public function save_invoice_db($service_id, $bat, $invoice_bill, $grand_total, $patient_name, $doctor_name, $ipopid, $pay_mode, $amount_paid, $discount)
    {
        $patient_name1 = explode('|', $patient_name);
        $patient_name = $patient_name1[0];
        $patient_id = $patient_name1[1];
        $doctor_name1 = explode('|', $doctor_name);
        $doctor_name = $doctor_name1[0];
        $this->db->query('INSERT INTO invoice_pharms (invoice_name, invoice_doctor, invoice_items, items_batch, invoice_total, payment, paid, discount, patient_id, created_by, ip_op) VALUES(:patient_name, :doctor_name, :service_id, :bat, :grand_total, :pay_mode, :amount_paid, :discount, :patient_id, :created_by, :ip_op)');
        $this->db->bind(':patient_name', $patient_name);
        $this->db->bind(':doctor_name', $doctor_name);
        $this->db->bind(':service_id', $service_id);
        $this->db->bind(':bat', $bat);
        $this->db->bind(':grand_total', $grand_total);
        $this->db->bind(':pay_mode', $pay_mode);
        $this->db->bind(':amount_paid', $amount_paid);
        $this->db->bind(':discount', $discount);
        $this->db->bind(':patient_id', $patient_id);
        $this->db->bind(':created_by', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->bind(':ip_op', $ipopid);
        if($this->db->execute())
        {
            $service_id = explode(',', $service_id);
            $bat = explode(',', $bat);
            for ($i=0,$j=0; $i < sizeof($service_id)-1; $i=$i+2, $j++)
            { 
                $drug_id = $service_id[$i];
                $drug_qty = $service_id[$i+1];
                $batch = $bat[$j];
                $this->db->query('UPDATE stocks SET stock_quant = stock_quant - :drug_qty WHERE drug_id  = :drug_id AND stock_batch = :batch');
                $this->db->bind(':drug_qty', $drug_qty);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':drug_id', $drug_id);
                $this->db->execute();
            }  
            return true;          
        }
        else
        {
            return false;
        }
    }


    public function get_month_report($month_date,$today,$lim,$off)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE DATE(invoice_date_time) BETWEEN :month_date AND :today limit :lim OFFSET :off');
        $this->db->bind(':month_date', $month_date);
        $this->db->bind(':today', $today);
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
        return $row;
    }   
    
    public function get_today_report($today_date, $lim, $off)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE DATE(invoice_date_time) = :today_date limit :lim OFFSET :off');
        $this->db->bind(':today_date', $today_date);
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_new_order_count()
    {
        $this->db->query('SELECT * FROM invoice_pharms');
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }


    public function get_all_drug_count()
    {
        $this->db->query('SELECT * FROM drugs');
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_all_stock_count()
    {
        $this->db->query('SELECT * FROM stocks');
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }


//me//

public function get_exp_all($lim,$off)
    {
        $this->db->query('SELECT s.stock_id as stock_id ,
            d.drug_name as drug_name,
            d.gen_name as gen_name,
            d.drug_dossage as drug_dossage,
            s.stock_quant as stock_quant, 
            s.stock_batch as stock_batch, 
            s.stock_total as stock_total, 
            s.stock_expiry as stock_expiry 
            FROM drugs d, stocks s WHERE d.drug_id = s.drug_id 
            ORDER BY s.stock_expiry ASC LIMIT :lim OFFSET :off');
        $this->db->bind(':lim',$lim);   
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }
public function get_stock_all($lim,$off)
    {
        $this->db->query('SELECT s.stock_id as stock_id ,
            d.drug_name as drug_name,
            s.stock_quant as stock_quant, 
            s.stock_batch as stock_batch, 
            s.stock_expiry as stock_expiry,
            s.stock_distributor as stock_distributor,
            s.drug_cgst as drug_cgst,
            s.drug_sgst as drug_sgst,
            s.drug_taxable_amount as drug_taxable_amount,
            s.drug_buy_cost as drug_buy_cost,
            s.drug_sell_cost as drug_sell_cost,
            s.stock_total as stock_total, 
            s.stock_date as stock_date
            FROM drugs d, stocks s WHERE d.drug_id = s.drug_id 
            ORDER BY s.stock_id ASC LIMIT :lim OFFSET :off');
        $this->db->bind(':lim',$lim);   
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

 public function get_today_order_count()
    {   
        $d=date('Y-m-d');
        $this->db->query('SELECT * FROM invoice_pharms WHERE date(invoice_date_time) = :d');
        $this->db->bind(':d',$d); 
        $this->db->resultSet();
        $counter = $this->db->rowCount();
        return $counter;
    }
    public function get_today_order_total_count()
    {   
        $d=date('Y-m-d');
        $this->db->query('SELECT * FROM invoice_pharms WHERE date(invoice_date_time) = :d');
        $this->db->bind(':d',$d); 
         $row = $this->db->resultSet();
        return $row;
    }
public function get_mem_data($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }
 public function update_password_db($cpass, $id, $photo)
    {
        $this->db->query('UPDATE users SET mem_pass = :cpass, mem_photo = :photo WHERE mem_id = :id');
        $this->db->bind(':cpass', $cpass);
        $this->db->bind(':id', $id);
        $this->db->bind(':photo', $photo);
        $this->db->execute();
        return true;
    }

 public function get_all_invoice_pharma($id)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }
    public function get_patient_name_for_order($a)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :id');
        $this->db->bind(':id', $a);
        $row = $this->db->single();
        return $row;
    }
 public function getPriceDb($drugId, $batchName)
    {
        $this->db->query('SELECT drug_sell_cost FROM stocks WHERE drug_id = :drugId AND stock_batch = :batchName');
        $this->db->bind(':drugId', $drugId);
        $this->db->bind(':batchName', $batchName);
        $row = $this->db->single();
        return $row->drug_sell_cost;
    }
      public function get_search_orders($inv_id)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_id=:inv_id');
        $this->db->bind(':inv_id',$inv_id);
        $row = $this->db->resultSet();
        return $row;
    }
    public function get_patient_orders($patient_name)
    {
        $this->db->query("SELECT * FROM invoice_pharms WHERE invoice_name LIKE concat('%', :patient_name, '%') ORDER BY invoice_id DESC LIMIT 10 ");
        $this->db->bind(':patient_name',$patient_name);
        $row = $this->db->resultSet();
        return $row;
    }
    public function prescription_search_by_id_db($visit_id)
    {
        $this->db->query("SELECT * from ipd WHERE ipd_admit_id LIKE concat(:visit_id, '%') LIMIT 1");
        $this->db->bind(':visit_id', $visit_id);
        $row = $this->db->single();
        return $row;
    }
    public function get_patient_by_id($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_doctor_by_id($d_id)
    {
        $this->db->query('SELECT * FROM doctors WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->resultSet();
        return $row;
    }
public function get_all_prescription_admit($lim,$off)
    {
        $this->db->query('SELECT * FROM ipd ORDER BY ipd_admit_id DESC limit :lim OFFSET :off ');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }
    public function doctor_name($id)
    {
        $this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
        $this->db->bind(':id', $id);
        $name = $this->db->single();
        if($name == NULL)
        {
            return "no doctor listed";
        }
        else
        {
            $name = $name->doctor_name;
            return $name;
        }
        
    }

//me end //


    public function save_invoice_db_s($data)
    {
        $this->db->query('INSERT INTO invoice_orders(product_name, qunatity, item_price, buying_price, due_dates, total, sub_total, delivery_mode, due_date,total_item,discount,gst,grand_total,payment_tems,item_expected_date,comany_name,company_address,item_delivery_address) VALUES(:product, :qty, :bat, :price,:due_date, :total, :sub_total, :mode_of_delivery, :due_days,:total_item,:discount,:extra_tax,:grand_total,:payment_terms,:expected_date,:company_name,:comapny_details,:delivery_address)');
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':bat', $data['bat']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':due_date', $data['due_date']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':mode_of_delivery', $data['mode_of_delivery']);
        $this->db->bind(':due_days', $data['due_date']);
        $this->db->bind(':total_item', $data['total_item']);
        $this->db->bind(':discount', $data['discount']);
        $this->db->bind(':extra_tax', $data['extra_tax']);
        $this->db->bind(':grand_total', $data['grand_total']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':expected_date', $data['expected_date']);
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':comapny_details', $data['comapny_details']);
        $this->db->bind(':delivery_address', $data['delivery_address']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }


    public function get_data(){

        $this->db->query('SELECT * FROM invoice_orders order by invoice_id DESC limit 1');
        $row = $this->db->resultSet();
        return $row;
    }

    public function update_order($invoice_id){
        $this->db->query('UPDATE invoice_orders SET order_status = 1 WHERE invoice_id = :invoice_id');
        $this->db->bind(':invoice_id', $invoice_id);
        $row = $this->db->execute();
        if($row)
            return true;
        else
            return false;

    }
    public function reject_order($invoice_id){
        $this->db->query('UPDATE invoice_orders SET order_status = 2 WHERE invoice_id = :invoice_id');
        $this->db->bind(':invoice_id', $invoice_id);
        $row = $this->db->execute();
        if($row)
            return true;
        else
            return false;

    }
    public function deliverd_update($invoice_id){
        $this->db->query('UPDATE invoice_orders SET order_status = 3 WHERE invoice_id = :invoice_id');
        $this->db->bind(':invoice_id', $invoice_id);
        $row = $this->db->execute();
        if($row)
            return true;
        else
            return false;

    }

    public function get_new_list($id){
        $this->db->query('SELECT * FROM invoice_orders WHERE invoice_id =:id');
        $this->db->bind(':id',$id);

        $row = $this->db->resultSet();
        return $row;

    }
    public function add_purchased($id,$data)
    {
        $this->db->query('SELECT * FROM invoice_orders WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
      
        $product_name = explode('|', $row->product_name);
        $qty = explode('|', $row->qunatity);
        $itemPrice = explode('|', $row->item_price);
        $buyingPrice = explode('|', $row->buying_price);
        $gst = (int)$row->gst;
        $company_name = $row->comany_name;
        $due_date = explode('|', $row->due_date);
        for ($i=0; $i < sizeof($qty); $i++)
        { 
            $product_nam = explode('(', $product_name[$i]);
            $product_id = explode(')', $product_nam[1]);

            $this->db->query('INSERT INTO stocks (drug_id, stock_total, stock_batch, stock_expiry, stock_distributor, drug_cgst, drug_sgst, drug_buy_cost, drug_sell_cost, stock_receiving, stock_date, purchase_id, stock_quant) VALUES(:product_id, :deliverd, :batch, :expiry, :company_name, :gst, :gst, :buying_price, :item_price, :qty, :due_date, :id, :deliverd)');
            $this->db->bind(':product_id', $product_id[0]);
            $this->db->bind(':deliverd', $data['deliverd'][$i]);
            $this->db->bind(':batch', $data['batch'][$i]);
            $this->db->bind(':expiry', $data['expiry'][$i]);
            $this->db->bind(':company_name', $company_name[$i]);
            $this->db->bind(':gst', $gst/2);
            $this->db->bind(':buying_price', $buyingPrice[$i]);
            $this->db->bind(':item_price', $itemPrice[$i]);
            $this->db->bind(':qty', $qty[$i]);
            $this->db->bind(':due_date', $due_date[$i]);
            $this->db->bind(':id', $id);
            $this->db->execute();
        }
        
        $this->db->query('UPDATE invoice_orders SET order_status = 5 WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_stock_orders($id){

        $this->db->query('SELECT * FROM stocks WHERE purchase_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function update_purchased($id,$data)
    {
        for ($i=0; $i < sizeof($data['recived']); $i++)
        { 
            $this->db->query('UPDATE stocks SET stock_total = :recived, stock_quant = :recived WHERE purchase_id = :id AND drug_id = :did');
            $this->db->bind(':recived', $data['recived'][$i]);
            $this->db->bind(':id', $id);
            $this->db->bind(':did', $data['id'][$i]);
            $this->db->execute();
        }
        return true;

        }

        public function get_invice_orders()
    {
    $this->db->query('SELECT * FROM invoice_orders ORDER BY invoice_id DESC');
        $row = $this->db->resultSet();
        return $row;
    }




    public function saveSupplier($data)
    {
        $this->db->query('INSERT INTO suppliers (s_name, s_phone, s_email, s_gstin, s_address) VALUES(:name, :phone, :email, :gstin, :address)');
        $this->db->bind('name', $data['name']);
        $this->db->bind('phone', $data['phone']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('gstin', $data['gstin']);
        $this->db->bind('address', $data['address']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAllSup($lim, $off)
    {
        $this->db->query('SELECT * FROM suppliers ORDER BY s_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $row = $this->db->resultSet();
    }

    public function getAllSup1()
    {
        $this->db->query('SELECT * FROM suppliers');
        return $row = $this->db->resultSet();
    }

    public function auto_drug_namez($filter)
    {
        $this->db->query('SELECT * FROM drugs WHERE drug_name LIKE concat(:filter, "%")');
        $this->db->bind(':filter', $filter);
        return $row = $this->db->resultSet();
    }

    public function getCompanyAddress()
    {
        $this->db->query('SELECT client_address FROM service_provider');
        return $row = $this->db->single();
    }

    public function get_doctors_list1()
    {
        $this->db->query('SELECT * FROM suppliers');
        return $row = $this->db->resultSet();
    }

    public function deleteAllInvoiceEdit()
    {
        $this->db->query('DELETE FROM edit_invoice');
        $this->db->execute();
    }

    public function getTheEditInvoiceDetails($id)
    {
        // $this->db->query('DELETE FROM edit_invoice');
        // $this->db->execute();

        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        $invoice_items = explode(',', $row->invoice_items);
        unset($invoice_items[sizeof($invoice_items)-1]);
        $invoice_batch = explode(',', $row->items_batch);
        $invoice_name = $row->invoice_name;
        $invoice_doctor = $row->invoice_doctor;

        for ($i=0, $j=0; $i < sizeof($invoice_items); $i=$i+2, $j++)
        { 
            if($i == 0)
            {
                $status = 1;
            }
            else
            {
                $status = 0;
            }
            $this->db->query('SELECT drug_name FROM drugs WHERE drug_id = :id');
            $this->db->bind(':id', $invoice_items[$i]);
            $drug_name1 = $this->db->single();
            $drug_name = $drug_name1->drug_name;

            $this->db->query('SELECT drug_sell_cost FROM stocks WHERE drug_id = :id AND stock_batch = :bat');
            $this->db->bind(':id', $invoice_items[$i]);
            $this->db->bind(':bat', $invoice_batch[$j]);
            $stock = $this->db->single();
            $stock_price = $stock->drug_sell_cost;

            $this->db->query('INSERT INTO edit_invoice (edit_drug_name, edit_drug_id, edit_batch, edit_qty, edit_price, edit_status) VALUES(:drug_name, :drug_id, :bat, :qty, :price, :status)');
            $this->db->bind(':drug_name', $drug_name);
            $this->db->bind(':drug_id', $invoice_items[$i]);
            $this->db->bind(':qty', $invoice_items[$i+1]);
            $this->db->bind(':bat', $invoice_batch[$j]);
            $this->db->bind(':price', $stock_price);
            $this->db->bind(':status', $status);
            $this->db->execute();
        }
        return true;
    }

    public function getTheEditPharmacy()
    {
        $this->db->query('SELECT * FROM edit_invoice');
        return $row = $this->db->resultSet();
    }

    public function editSaveTheEditOrder($id, $product, $bat, $qty, $price, $total, $edit)
    {
        for ($i=0; $i < sizeof($id); $i++)
        { 
            $drugName = explode('(', $product[$i]);
            $drugName1 = explode(')', $drugName[1]);
            $dName = $drugName[0];
            $dId = $drugName1[0];
            $this->db->query('UPDATE edit_invoice SET edit_drug_name = :dName, edit_drug_id = :dId, edit_batch = :bat, edit_qty = :qty, edit_price = :price, edit_status = 0 WHERE edit_id = :id');
            $this->db->bind(':dName', $dName);
            $this->db->bind(':dId', $dId);
            $this->db->bind(':bat', $bat[$i]);
            $this->db->bind(':qty', $qty[$i]);
            $this->db->bind(':price', $price[$i]);
            $this->db->bind(':id', $id[$i]);
            $this->db->execute();
        }

        $this->db->query('UPDATE edit_invoice SET edit_status = 1 WHERE edit_id = :edit');
        $this->db->bind(':edit', $edit);
        $this->db->execute();
        return true;
    }

    public function deleteSaveTheEditOrder($id, $product, $bat, $qty, $price, $total, $remove)
    {
        for ($i=0; $i < sizeof($id); $i++)
        { 
            $drugName = explode('(', $product[$i]);
            $drugName1 = explode(')', $drugName[1]);
            $dName = $drugName[0];
            $dId = $drugName1[0];
            $this->db->query('UPDATE edit_invoice SET edit_drug_name = :dName, edit_drug_id = :dId, edit_batch = :bat, edit_qty = :qty, edit_price = :price, edit_status = 0 WHERE edit_id = :id');
            $this->db->bind(':dName', $dName);
            $this->db->bind(':dId', $dId);
            $this->db->bind(':bat', $bat[$i]);
            $this->db->bind(':qty', $qty[$i]);
            $this->db->bind(':price', $price[$i]);
            $this->db->bind(':id', $id[$i]);
            $this->db->execute();
        }

        $this->db->query('DELETE FROM edit_invoice WHERE edit_id = :remove');
        $this->db->bind(':remove', $remove);
        $this->db->execute();

        $this->db->query('SELECT edit_id FROM edit_invoice LIMIT 1');
        $makeOne = $this->db->single();
        $makeOne = $makeOne->edit_id;

        $this->db->query('UPDATE edit_invoice SET edit_status = 1 WHERE edit_id = :makeOne');
        $this->db->bind(':makeOne', $makeOne);
        $this->db->execute();
        return true;
    }

    public function addSaveTheEditOrder($id, $product, $bat, $qty, $price, $total)
    {
        for ($i=0; $i < sizeof($id); $i++)
        { 
            $drugName = explode('(', $product[$i]);
            $drugName1 = explode(')', $drugName[1]);
            $dName = $drugName[0];
            $dId = $drugName1[0];
            $this->db->query('UPDATE edit_invoice SET edit_drug_name = :dName, edit_drug_id = :dId, edit_batch = :bat, edit_qty = :qty, edit_price = :price, edit_status = 0 WHERE edit_id = :id');
            $this->db->bind(':dName', $dName);
            $this->db->bind(':dId', $dId);
            $this->db->bind(':bat', $bat[$i]);
            $this->db->bind(':qty', $qty[$i]);
            $this->db->bind(':price', $price[$i]);
            $this->db->bind(':id', $id[$i]);
            $this->db->execute();
        }
            $this->db->query('INSERT INTO edit_invoice (edit_status) VALUES(1)');
            $this->db->execute();

        return true;
    }

    public function defaultSaveTheEditOrder($id, $product, $bat, $qty, $price, $total)
    {
        for ($i=0; $i < sizeof($id); $i++)
        { 
            $drugName = explode('(', $product[$i]);
            $drugName1 = explode(')', $drugName[1]);
            $dName = $drugName[0];
            $dId = $drugName1[0];
            $this->db->query('UPDATE edit_invoice SET edit_drug_name = :dName, edit_drug_id = :dId, edit_batch = :bat, edit_qty = :qty, edit_price = :price, edit_status = 0 WHERE edit_id = :id');
            $this->db->bind(':dName', $dName);
            $this->db->bind(':dId', $dId);
            $this->db->bind(':bat', $bat[$i]);
            $this->db->bind(':qty', $qty[$i]);
            $this->db->bind(':price', $price[$i]);
            $this->db->bind(':id', $id[$i]);
            $this->db->execute();
        }
        return true;
    }
    
    public function getTheQuantity($actualIds, $itemsBatch)
    {
        $this->db->query('SELECT stock_quant FROM stocks WHERE drug_id = :actualIds AND stock_batch = :itemsBatch');
        $this->db->bind(':actualIds', $actualIds);
        $this->db->bind(':itemsBatch', $itemsBatch);
        return $row = $this->db->single();
    }

    public function removeStockOfTheMed($medId, $itemsBatch, $actualQty)
    {
        $this->db->query('UPDATE stocks SET stock_quant = stock_quant - :actualQty WHERE drug_id = :medId AND stock_batch = :itemsBatch');
        $this->db->bind(':medId', $medId);
        $this->db->bind(':itemsBatch', $itemsBatch);
        $this->db->bind(':actualQty', $actualQty);
        if($this->db->execute())
        {   
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function cancelThePreviousOrderByIdAndRestoreTheStocks($invoiceId)
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE invoice_id = :invoiceId');
        $this->db->bind(':invoiceId', $invoiceId);
        $order = $this->db->single();

        $items = explode(',', $order->invoice_items);
        $batch = explode(',', $order->items_batch);
        
        for ($i=0, $j=0; $i < sizeof($items)-1; $i=$i+2, $j++) 
        { 
            $this->db->query('UPDATE stocks SET stock_quant = stock_quant + :actualQty WHERE drug_id = :medId AND stock_batch = :itemsBatch');
            $this->db->bind(':medId', $items[$i]);
            $this->db->bind(':itemsBatch', $batch[$j]);
            $this->db->bind(':actualQty', $items[$i+1]);
            $this->db->execute();
        }

        $this->db->query('UPDATE invoice_pharms SET cancelled = 1 WHERE invoice_id = :invoiceId');
        $this->db->bind(':invoiceId', $invoiceId);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save_invoice_db_after_edit($service_id, $bat, $invoice_bill, $grand_total, $patient_name, $doctor_name, $ipopid, $pay_mode, $amount_paid, $discount)
    {
        $bat = implode(',', $bat);
        $patient_name1 = explode('|', $patient_name);
        $patient_name = $patient_name1[0];
        $doctor_name1 = explode('|', $doctor_name);
        $doctor_name = $doctor_name1[0];
        $this->db->query('INSERT INTO invoice_pharms (invoice_name, invoice_doctor, invoice_items, items_batch, invoice_total, payment, paid, discount) VALUES(:patient_name, :doctor_name, :service_id, :bat, :grand_total, :pay_mode, :amount_paid, :discount)');
        $this->db->bind(':patient_name', $patient_name);
        $this->db->bind(':doctor_name', $doctor_name);
        $this->db->bind(':service_id', $service_id);
        $this->db->bind(':bat', $bat);
        $this->db->bind(':grand_total', $grand_total);
        $this->db->bind(':pay_mode', $pay_mode);
        $this->db->bind(':amount_paid', $amount_paid);
        $this->db->bind(':discount', $discount);
        if($this->db->execute())
        {
            $service_id = explode(',', $service_id);
            $bat = explode(',', $bat);
            for ($i=0,$j=0; $i < sizeof($service_id)-1; $i=$i+2, $j++)
            { 
                $drug_id = $service_id[$i];
                $drug_qty = $service_id[$i+1];
                $batch = $bat[$j];
                $this->db->query('UPDATE stocks SET stock_quant = stock_quant - :drug_qty WHERE drug_id  = :drug_id AND stock_batch = :batch');
                $this->db->bind(':drug_qty', $drug_qty);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':drug_id', $drug_id);
                $this->db->execute();
            }            
        }
        else
        {
            return false;
        }
    }
     public function auto_item_name_new($cust)
    {
        $this->db->query("SELECT * FROM items WHERE name LIKE concat('%', :cust, '%') OR id LIKE concat('%', :cust, '%')");
        $this->db->bind(':cust',$cust);
        $row = $this->db->resultSet();
        return $row;
    }
    public function auto_item_name_by_stock($cust)
    {
        $this->db->query("SELECT * FROM stock WHERE item_id=:cust");
        $this->db->bind(':cust',$cust);
        $row = $this->db->single();
        return $row;
    }

}// end of class
?>
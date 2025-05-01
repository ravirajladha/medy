<?php
class Page
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function reselect_all_sessions()
    {
        $servername = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $dbname = DB_MAIN;

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }

        $sql2 = 'SELECT * FROM auth WHERE auth_email = "'.$_SESSION['email'].'"';
        $result = mysqli_query($conn, $sql2);
        // mysqli_num_rows($result);
        $row = $result->fetch_assoc();
        $_SESSION["db_name_for_assign"] = $row['auth_db_name'];
        return true;

    }



    public function add_item($data)
        {
            if(!empty($_FILES['files']['name']))
            {
                $f_name = $_FILES['files']['name'];
                $f_temp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $f_extension=explode('.', $f_name);
                $f_extension=strtolower(end($f_extension));
                $f_newfile=uniqid().'.' .$f_extension;
                $store="uploads/" .$f_newfile;
                move_uploaded_file($f_temp, $store);
                $store ="uploads/";
                $_SESSION['attachment']=$f_newfile;
            }
            else
            {
                $_SESSION['attachment']= "dumitem.png";
            }
            $dimension = $data['Length']."x".$data['width']."x".$data['height'];

            $this->db->query('INSERT INTO items(barcode, name, img, SKU, unit, dimension, Manufacturer_name,mfg_id, UPC, EAN, weight, brand, MPN, ISBN, selling_price, s_account, s_description, purchase_price, p_account, p_description, inventory_account_type, opening_stock, reorder_point, opening_stock_rate_per_unit, preferred_vendor, preferred_vendor_id, category_id, sc_id, sc2_id, sc3_id, receive, qty, discount, hsn,tax_pre,gst,igst,stock_on_hand,available_stock, type_id, model_id, category_new_id, subcategory_new_id, color_id, size_id, minstock, maxstock,part_no) 
                VALUES(:barcode, :name, :attachment, :sku, :unit, :dimension, :man_name,:mfg_id, :upc, :ean, :weight, :brand, :mpn, :isbn, :selling_price, :s_account, :s_description, :purchase_price, :p_account, :p_description, :inventory_type, :opening_stock, :reorder_point, :opening_stock_rate, :vendor, :vendor_id, :category, :sub_category,:sub_category2,:sub_category3, :rec, :recNumber, :discount, :hsn, :tax_pre, :gst, :igst,:opening_stock,0,:type_id,:model_id,:category_new_id,:subcategory_new_id,:color_id,:size_id, :minstock, :maxstock, :part_no)');
            // Bind values vendor_id
            $this->db->bind(':type_id', $data['type_id']);
            $this->db->bind(':model_id', $data['model_id']);
            $this->db->bind(':category_new_id', $data['category_new_id']);
            $this->db->bind(':subcategory_new_id', $data['subcategory_new_id']);
            $this->db->bind(':color_id', $data['color_id']);
            $this->db->bind(':size_id', $data['size_id']);

            $this->db->bind(':barcode', $data['barcode']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':sku', $data['sku']);
            $this->db->bind(':unit', $data['unit']);
            $this->db->bind(':dimension', $dimension);  
            $this->db->bind(':man_name', $data['man_name']);
             $this->db->bind(':mfg_id', $data['mfg_id']);
            $this->db->bind(':upc', $data['upc']);
            $this->db->bind(':ean', $data['ean']);
            $this->db->bind(':weight', $data['weight']);
            $this->db->bind(':brand', $data['brand']);
            $this->db->bind(':mpn', $data['mpn']);
            $this->db->bind(':isbn', $data['isbn']);
            $this->db->bind(':selling_price', $data['selling_price']);
            $this->db->bind(':s_account', $data['s_account']);
            $this->db->bind(':s_description', $data['s_description']);
            $this->db->bind(':purchase_price', $data['purchase_price']);
            $this->db->bind(':p_account', $data['p_account']);
            $this->db->bind(':p_description', $data['p_description']);
            $this->db->bind(':inventory_type', $data['inventory_type']);
            $this->db->bind(':opening_stock', $data['opening_stock']);
            $this->db->bind(':reorder_point', $data['reorder_point']);
            $this->db->bind(':opening_stock_rate', $data['opening_stock_rate']);
            $this->db->bind(':vendor', $data['vendor']);
            $this->db->bind(':vendor_id', $data['vendor_id']);
            $this->db->bind(':attachment',$_SESSION['attachment']);
            $this->db->bind(':sub_category', $data['sub_category']);
            $this->db->bind(':sub_category2', $data['sub_category2']);
            $this->db->bind(':sub_category3', $data['sub_category3']);
            $this->db->bind(':category', $data['category']);
            $this->db->bind(':rec', $data['rec']);
            $this->db->bind(':recNumber', $data['recNumber']);
            $this->db->bind(':discount', $data['discount']);
            $this->db->bind(':hsn', $data['hsn']);
            $this->db->bind(':tax_pre', $data['tax_pre']);
            $this->db->bind(':gst', $data['gst']);
            $this->db->bind(':igst', $data['igst']);
            $this->db->bind(':minstock',$data['minstock']);
            $this->db->bind(':maxstock',$data['maxstock']);
             $this->db->bind(':part_no',$data['part_no']);
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    public function get_all_items($lim, $off)
    {
        $this->db->query("SELECT * FROM items ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_all_non_purchase_limit($lim, $off)
    {
        $this->db->query("SELECT * FROM nonpurchase ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }

    public function get_item_for_water_mark($lim, $off)
    {
        $this->db->query("SELECT * FROM items ORDER BY id ASC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_all_items_for_dropdown()
    {
        $this->db->query("SELECT * FROM items");
        return $results = $this->db->resultSet();
    }
    public function get_all_items_for_waterlevel()
    {
        $this->db->query("SELECT * FROM items");
        return $results = $this->db->resultSet();
    }
    public function get_all_items_dist()
    {
        $this->db->query("SELECT * FROM items");
        return $results = $this->db->resultSet();
    }

    public function get_all_items_id($itm)
    {
        $this->db->query("SELECT * FROM items WHERE id LIKE concat(:itm) LIMIT 5");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
    public function get_all_items_id_water_level($itm)
    {
        $this->db->query("SELECT * FROM items WHERE id LIKE concat(:itm) LIMIT 5");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }

    public function get_all_items_name($itm)
    {
        $this->db->query("SELECT * FROM items WHERE name LIKE concat('%', :itm, '%') LIMIT 10");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
    public function get_all_items_namewater_level($itm)
    {
        $this->db->query("SELECT * FROM items WHERE name LIKE concat('%', :itm, '%') LIMIT 10");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
    public function get_all_items_minstockwater_level($itm)
    {
        $this->db->query("SELECT * FROM items ORDER BY minstock ASC");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
     public function get_all_items_maxstockwater_level($itm)
    {
        $this->db->query("SELECT * FROM items ORDER BY maxstock DESC");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }

    public function get_all_customer_by_name($itm)
    {
        $this->db->query("SELECT * FROM customer WHERE customer_display_name LIKE concat('%', :itm, '%') LIMIT 10");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }

    public function get_all_items_cat($itm)
    {
        $this->db->query("SELECT * FROM items INNER JOIN category ON items.category_id = category.category_id WHERE category.category_name LIKE concat('%', :itm, '%') LIMIT 10");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
    public function get_all_items_comp($itm)
    {
        $this->db->query("SELECT * FROM items WHERE brand LIKE concat('%', :itm, '%')");
        $this->db->bind(':itm', $itm);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details1($category_id,$subCategory,$subCategory1,$subCategory2)
    {
        $this->db->query("SELECT * FROM items WHERE category_id=:category_id AND sc_id=:subCategory AND  sc2_id=:subCategory1 AND sc3_id=:subCategory2 ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details2($category_id,$subCategory,$subCategory1)
    {
        $this->db->query("SELECT * FROM items WHERE category_id=:category_id AND sc_id=:subCategory AND  sc2_id=:subCategory1");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details3($category_id,$subCategory)
    {
        $this->db->query("SELECT * FROM items WHERE category_id=:category_id AND sc_id=:subCategory");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details4($category_id)
    {
        $this->db->query("SELECT * FROM items WHERE category_id=:category_id");
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details1s($category_id,$subCategory,$subCategory1,$subCategory2)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details2s($category_id,$subCategory,$subCategory1)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details3s($category_id,$subCategory)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details4s($category_id)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id");
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details() 
    {
        $this->db->query("SELECT * FROM items");
        return $results = $this->db->resultSet();
    }

    public function del_item($id)
    {
        $this->db->query("DELETE FROM items WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

     public function delete_size($id)
    {
        $this->db->query("DELETE FROM size WHERE size_id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
     public function delete_color($id)
    {
        $this->db->query("DELETE FROM color WHERE color_id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function edit_item($data,$id)
        {
            
            if(!empty($_FILES['files']['name']))
            {
                $f_name = $_FILES['files']['name'];
                $f_temp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $f_extension=explode('.', $f_name);
                $f_extension=strtolower(end($f_extension));
                $f_newfile=uniqid().'.' .$f_extension;
                $store="uploads/" .$f_newfile;
                move_uploaded_file($f_temp, $store);
                $store ="uploads/";
                $_SESSION['attachment']=$f_newfile;
            }
            else
            {
                $this->db->query("SELECT * FROM items where id = :id ");
                $this->db->bind(':id', $id);
                $results = $this->db->single();
                $_SESSION['attachment'] = $results->img;
            }
            $dimension = $data['Length']."x".$data['width']."x".$data['height'];

            $this->db->query('UPDATE items SET name=:name ,img= :attachment, SKU=:sku, unit=:unit, dimension=:dimension, Manufacturer_name=:man_name, UPC=:upc, EAN=:ean, weight=:weight, brand=:brand, MPN=:mpn, ISBN=:isbn, selling_price=:selling_price, s_account=:s_account, s_description=:s_description, purchase_price=:purchase_price, p_account=:p_account, p_description=:p_description, inventory_account_type=:inventory_type, opening_stock=:opening_stock,reorder_point=:reorder_point,opening_stock_rate_per_unit=:opening_stock_rate, preferred_vendor=:vendor, barcode=:barcode, preferred_vendor_id=:preferred_vendor_id, category_id=:category, sc_id=:sub_category, sc2_id=:sub_category2, sc3_id=:sub_category3, receive=:rec, qty=:qty, igst=:igst, discount=:discount,hsn=:hsn, tax_pre=:tax_pre,gst=:gst,igst=:igst,type_id=:type_id,model_id=:model_id,category_new_id=:category_new_id,subcategory_new_id=:subcategory_new_id,color_id=:color_id,size_id=:size_id, mfg_id=:mfg_id, minstock=:minstock, maxstock=:maxstock, part_no=:part_no WHERE id = :id');
            // Bind values
            $this->db->bind(':type_id', $data['type_id']);
            $this->db->bind(':model_id', $data['model_id']);
            $this->db->bind(':category_new_id', $data['category_new_id']);
            $this->db->bind(':subcategory_new_id', $data['subcategory_new_id']);
            $this->db->bind(':color_id', $data['color_id']);
            $this->db->bind(':size_id', $data['size_id']);

            $this->db->bind(':barcode', $data['barcode']);
            $this->db->bind(':preferred_vendor_id', $data['vendor_id']);
            $this->db->bind(':category', $data['category']);
            $this->db->bind(':sub_category', $data['sub_category']);
            $this->db->bind(':sub_category2', $data['sub_category2']);
            $this->db->bind(':sub_category3', $data['sub_category3']);
            $this->db->bind(':rec', $data['rec']);
            $this->db->bind(':qty', $data['recNumber']);
            $this->db->bind(':id', $id);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':sku', $data['sku']);
            $this->db->bind(':unit', $data['unit']);
            $this->db->bind(':dimension', $dimension);  
            $this->db->bind(':man_name', $data['man_name']);
             $this->db->bind(':mfg_id', $data['mfg_id']);
            $this->db->bind(':upc', $data['upc']);
            $this->db->bind(':ean', $data['ean']);
            $this->db->bind(':weight', $data['weight']);
            $this->db->bind(':brand', $data['brand']);
            $this->db->bind(':mpn', $data['mpn']);
            $this->db->bind(':isbn', $data['isbn']);
            $this->db->bind(':selling_price', $data['selling_price']);
            $this->db->bind(':s_account', $data['s_account']);
            $this->db->bind(':s_description', $data['s_description']);
            $this->db->bind(':purchase_price', $data['purchase_price']);
            $this->db->bind(':p_account', $data['p_account']);
            $this->db->bind(':p_description', $data['p_description']);
            $this->db->bind(':inventory_type', $data['inventory_type']);
            $this->db->bind(':opening_stock', $data['opening_stock']);
            $this->db->bind(':reorder_point', $data['reorder_point']);
            $this->db->bind(':opening_stock_rate', $data['opening_stock_rate']);
            $this->db->bind(':vendor', $data['vendor']);
            $this->db->bind(':attachment',$_SESSION['attachment']);
          
            $this->db->bind(':discount', $data['discount']);
            $this->db->bind(':hsn', $data['hsn']);
             $this->db->bind(':tax_pre', $data['tax_pre']);
            $this->db->bind(':gst', $data['gst']);
            $this->db->bind(':igst', $data['igst']);
            $this->db->bind(':minstock',$data['minstock']);
            $this->db->bind(':maxstock',$data['maxstock']);
             $this->db->bind(':part_no',$data['part_no']);
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    public function add_purchase_order_details($data)
    {

        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            echo $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }
        $this->db->query('INSERT INTO purchase(vendor,vendor_id, bill_address, deliver_to, purchase_order, reference, ndate, expected_delivery_date, shipment_preference, payment_terms, delivery_method, salesperson, customer_notes, t_and_c, img, temp_id) VALUES(:vendor, :vendor_id,:bill_address, :deliver_to, :purchase_order, :reference, :ndate, :expected_delivery_date, :shipment_preference, :payment_terms, :delivery_method, :salesperson, :customer_notes, :t_and_c, :attachment, :tempId)');
        // Bind values
        $this->db->bind(':vendor', $data['vendor']);
        $this->db->bind(':deliver_to', $data['deliver_to']);
        $this->db->bind(':purchase_order', $data['purchase_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':shipment_preference', $data['shipment_preference']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':vendor_id', $data['vendor_id']);
        $this->db->bind(':tempId', $data['tempId']);
         $this->db->bind(':bill_address',$data['bill_address']);
        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM purchase WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            $tId = $this->db->single();
            return $tId->id;
        } else {
            return false;
        }
    }
     public function update_purchase_order_details($data)
    {

        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            echo $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }
        $this->db->query('INSERT INTO purchase(vendor,vendor_id, bill_address, deliver_to, purchase_order, reference, ndate, expected_delivery_date, shipment_preference, payment_terms, delivery_method, salesperson, customer_notes, t_and_c, img, temp_id) VALUES(:vendor, :vendor_id,:bill_address, :deliver_to, :purchase_order, :reference, :ndate, :expected_delivery_date, :shipment_preference, :payment_terms, :delivery_method, :salesperson, :customer_notes, :t_and_c, :attachment, :tempId)');
        // Bind values
        $this->db->bind(':vendor', $data['vendor']);
        $this->db->bind(':deliver_to', $data['deliver_to']);
        $this->db->bind(':purchase_order', $data['purchase_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':shipment_preference', $data['shipment_preference']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':vendor_id', $data['vendor_id']);
        $this->db->bind(':tempId', $data['tempId']);
         $this->db->bind(':bill_address',$data['bill_address']);
        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM purchase WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            $tId = $this->db->single();
            return $tId->id;
        } else {
            return false;
        }
    }
    public function get_all_pur()
    {
        $this->db->query("SELECT * FROM purchase ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }
    public function del_purchase($id)
    {
        $this->db->query("DELETE FROM purchase WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_single_pur($id)
    {
        $this->db->query("SELECT * FROM purchase WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }

    public function get_single_item($id)
    {
        $this->db->query("SELECT * FROM items WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
     public function update_purchase_order_details_old($data, $id)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }


        $this->db->query('UPDATE purchase SET vendor=:vendor, deliver_to=:deliver_to, purchase_order=:purchase_order,reference=:reference,ndate=:ndate,expected_delivery_date=:expected_delivery_date,shipment_preference=:shipment_preference, payment_terms=:payment_terms, delivery_method=:delivery_method, salesperson=:salesperson, product=:product, qty=:qty, price=:price, total=:total,sub_total=:sub_total,tax=:tax,tax_amount=:tax_amount,total_amount=:total_amount,customer_notes=:customer_notes,t_and_c=:t_and_c,img=:attachment, bill_address=:bill_address, vendor_id=:vendor_id WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':vendor', $data['vendor']);
        $this->db->bind(':deliver_to', $data['deliver_to']);
        $this->db->bind(':purchase_order', $data['purchase_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':shipment_preference', $data['shipment_preference']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':tax', $data['tax']);
        $this->db->bind(':tax_amount', $data['tax_amount']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':vendor_id',$data['vendor_id']);
        $this->db->bind(':bill_address',$data['bill_address']);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_all_stock()
    {
        $this->db->query("SELECT * FROM stock");
        return $results = $this->db->resultSet();
    }

    public function add_stock_add($s, $rec, $batch)
    {
        $total_rem = (int)$s->total_rem - (int)$rec;
        $rec = (int)$s->total_received + (int)$rec;
        $this->db->query('UPDATE purchase SET total_rem = :total_rem, total_received = :total_received WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $s->id);
        $this->db->bind(':total_rem', $total_rem);
        $this->db->bind(':total_received', $rec);
        // Execute
        if ($this->db->execute()) {
            $this->db->query('INSERT INTO stock(img, name,order_number,batch, stock_on_hand, remaining_stock, stock_total_receive, Expected_date) VALUES (:img,:name,:purchase_order,:batch,:stock_on_hand,:remaining_stock,:stock_total_receive,:expected_delivery_date)');
            $this->db->bind(':batch', $batch);
            $this->db->bind(':img', $s->img);
            $this->db->bind(':name', $s->vendor);
            $this->db->bind(':purchase_order', $s->purchase_order);
            $this->db->bind(':stock_on_hand', $rec);
            $this->db->bind(':remaining_stock', $total_rem);
            $this->db->bind(':stock_total_receive', $rec);
            $this->db->bind(':expected_delivery_date', $s->expected_delivery_date);
            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function get_all_vender()
    {
        $this->db->query("SELECT * FROM vendor");
        return $results = $this->db->resultSet();
    }
    public function saveTheVendorDetailsDb($data)
    {
        $this->db->query('INSERT INTO vendor (primarySalutation,firstName,lastName,compName,dispName,venEmail,vendPhoneHome,vendPhoneWork,vendWeb,vendCurrency,vendPayment,facebook,twittetr,attension,country,street1,street2,city,state,zipcode,phoneAdd,fax,contSalu,contFirstname,contLastName,contEmail,contWorkPhone,contWorkMobile,gst,aadhar,passport,dob,aniversary,blood,mfg_sort) VALUES(:primarySalutation,:firstName,:lastName,:compName,:dispName,:venEmail,:vendPhoneHome,:vendPhoneWork,:vendWeb,:vendCurrency,:vendPayment,:facebook,:twittetr,:attension,:country,:street1,:street2,:city,:state,:zipcode,:phoneAdd,:fax,:contSalu,:contFirstname,:contLastName,:contEmail,:contWorkPhone,:contWorkMobile,:gst,:aadhar,:passport,:dob,:aniversary,:blood,:mfg_sort)');
        $this->db->bind(':primarySalutation', $data['primarySalutation']);
        $this->db->bind(':firstName', $data['firstName']);
        $this->db->bind(':lastName', $data['lastName']);
        $this->db->bind(':compName', $data['compName']);
        $this->db->bind(':dispName', $data['dispName']);
        $this->db->bind(':venEmail', $data['venEmail']);
        $this->db->bind(':vendPhoneHome', $data['vendPhoneHome']);
        $this->db->bind(':vendPhoneWork', $data['vendPhoneWork']);
        $this->db->bind(':vendWeb', $data['vendWeb']);
        $this->db->bind(':vendCurrency', $data['vendCurrency']);
        $this->db->bind(':vendPayment', $data['vendPayment']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twittetr', $data['twittetr']);
        $this->db->bind(':attension', $data['attension']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zipcode', $data['zipcode']);
        $this->db->bind(':phoneAdd', $data['phoneAdd']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':contSalu', $data['contSalu']);
        $this->db->bind(':contFirstname', $data['contFirstname']);
        $this->db->bind(':contLastName', $data['contLastName']);
        $this->db->bind(':contEmail', $data['contEmail']);
        $this->db->bind(':contWorkPhone', $data['contWorkPhone']);
        $this->db->bind(':contWorkMobile', $data['contWorkMobile']);
        $this->db->bind(':gst', $data['gst']);
        $this->db->bind(':aadhar', $data['aadhar']);
        $this->db->bind(':passport', $data['passport']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':aniversary', $data['aniversary']);
        $this->db->bind(':blood', $data['blood']);
        $this->db->bind(':mfg_sort', $data['mfg_sort']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function all_stock_count()
    {
        $this->db->query("SELECT sum(stock_on_hand) AS a FROM stock");
        // Bind value
        $x = $this->db->single();
        return $x->a;
        // $count = $this->db->rowCount();
        // return $count;
    }
    public function all_rem_stock_count()
    {
        $this->db->query("SELECT sum(remaining_stock) AS a FROM stock");
        // Bind value
        $x = $this->db->single();
        return $x->a;
        // $count = $this->db->rowCount();
        // return $count;
    }
    public function all_total_quantity_ordered()
    {
        $this->db->query("SELECT * FROM purchase_order");
        // Bind value
        $x = $this->db->resultSet();
        return $x;
    }
    public function all_total_purchase_sum()
    {
        $this->db->query("SELECT sum(sub_total) AS a FROM purchase");
        // Bind value
        $x = $this->db->single();
        return $x->a;
        // $count = $this->db->rowCount();
        // return $count;
    }
    public function get_vendor_by_id($id)
    {
        $this->db->query("SELECT * FROM vendor");
        return $results = $this->db->single();
    }
    public function get_all_customers()
    {
        if($_SESSION['ctype'] == 1)
        {
            $this->db->query("SELECT * FROM customer WHERE cp_priority = 1");
            return $results = $this->db->resultSet();
        }else
        {
            $this->db->query("SELECT * FROM customer WHERE cp_priority = 0");
            return $results = $this->db->resultSet();
        }
        
    }
   public function save_customer_details($data)
    {
        $this->db->query('INSERT INTO customer(customer_type, customer_sa, customer_first_name, customer_last_name, company_name, customer_display_name, customer_email, customer_phno_home, customer_phno_work, customer_website, currency, payment_terms, facebook, twitter, b_attention, b_country, b_street1, b_street2, b_city, b_state, b_zip_code, b_phone, b_fax, s_attention, s_country, s_street1, s_street2, s_city, s_state, s_zip_code, s_phone, s_fax, cp_salut, cp_first_name, cp_last_name, cp_email, cp_work_phone, cp_mobile,gst,aadhar,passport,dob,aniversary,blood,transport,cp_priority
         ) VALUES(:c_type,:salutation,:f_name,:l_name,:company_name,:c_display_name,:c_email,:customer_home_phone,:customer_work_phone,:website,:currency,:payment_terms,:facebook,:twitter,:attention,:country,:street1,:street2,:city,:state,:zip_code,:phone,:fax,:cp_attention,:cp_country,:cp_street1,:cp_street2,:cp_city,:cp_state,:cp_zip_code,:cp_phone,:cp_fax,:cp_salutation,:cp_f_name,:cp_l_name,:cp_email,:cp_working_phone,:cp_mobile,:gst,:aadhar,:passport,:dob,:aniversary,:blood, :transport,:cp)');
        $this->db->bind(':c_type', $data['c_type']);
        $this->db->bind(':salutation', $data['salutation']);
        $this->db->bind(':f_name', $data['f_name']);
        $this->db->bind(':l_name', $data['l_name']);
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':c_display_name', $data['c_display_name']);
        $this->db->bind(':c_email', $data['c_email']);
        $this->db->bind(':customer_home_phone', $data['customer_home_phone']);
        $this->db->bind(':customer_work_phone', $data['customer_work_phone']);
        $this->db->bind(':website', $data['website']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twitter', $data['twitter']);
        $this->db->bind(':attention', $data['attention']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':cp_attention', $data['cp_attention']);
        $this->db->bind(':cp_country', $data['cp_country']);
        $this->db->bind(':cp_street1', $data['cp_street1']);
        $this->db->bind(':cp_street2', $data['cp_street2']);
        $this->db->bind(':cp_city', $data['cp_city']);
        $this->db->bind(':cp_state', $data['cp_state']);
        $this->db->bind(':cp_zip_code', $data['cp_zip_code']);
        $this->db->bind(':cp_phone', $data['cp_phone']);
        $this->db->bind(':cp_fax', $data['cp_fax']);
        $this->db->bind(':cp_salutation', $data['cp_salutation']);
        $this->db->bind(':cp_f_name', $data['cp_f_name']);
        $this->db->bind(':cp_l_name', $data['cp_l_name']);
        $this->db->bind(':cp_email', $data['cp_email']);
        $this->db->bind(':cp_working_phone', $data['cp_working_phone']);
        $this->db->bind(':cp_mobile', $data['cp_mobile']);
        $this->db->bind(':gst', $data['gst']);
        $this->db->bind(':aadhar', $data['aadhar']);
        $this->db->bind(':passport', $data['passport']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':aniversary', $data['aniversary']);
        $this->db->bind(':blood', $data['blood']);
        $this->db->bind(':transport', $data['transport']);
        $this->db->bind(':cp', $data['cp']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_customer_details($data)
    {
        $this->db->query('UPDATE customer SET customer_type=:c_type,customer_sa=:salutation,customer_first_name=:f_name,customer_last_name=:l_name,company_name=:company_name,customer_display_name=:c_display_name,customer_email=:c_email,customer_phno_home=:customer_home_phone,customer_phno_work=:customer_work_phone,customer_website=:website,currency=:currency,payment_terms=:payment_terms,facebook=:facebook,twitter=:twitter,b_attention=:attention,b_country=:country,b_street1=:street1,b_street2=:street2,b_city=:city,b_state=:state,b_zip_code=:zip_code,b_phone=:phone,b_fax=:fax,s_attention=:cp_attention,s_country=:cp_country,s_street1=:cp_street1,s_street2=:cp_street2,s_city=:cp_city,s_state=:cp_state,s_zip_code=:cp_zip_code,s_phone=:cp_phone,s_fax=:cp_fax,cp_salut=:cp_salutation,cp_first_name=:cp_f_name,cp_last_name=:cp_l_name,cp_email=:cp_email,cp_work_phone=:cp_working_phone,cp_mobile=:cp_mobile, gst =:gst, aadhar=:aadhar, passport=:passport, dob=:dob, aniversary=:aniversary, blood=:blood, transport=:transport, cp_priority=:cp WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':c_type', $data['c_type']);
        $this->db->bind(':salutation', $data['salutation']);
        $this->db->bind(':f_name', $data['f_name']);
        $this->db->bind(':l_name', $data['l_name']);
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':c_display_name', $data['c_display_name']);
        $this->db->bind(':c_email', $data['c_email']);
        $this->db->bind(':customer_home_phone', $data['customer_home_phone']);
        $this->db->bind(':customer_work_phone', $data['customer_work_phone']);
        $this->db->bind(':website', $data['website']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twitter', $data['twitter']);
        $this->db->bind(':attention', $data['attention']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':cp_attention', $data['cp_attention']);
        $this->db->bind(':cp_country', $data['cp_country']);
        $this->db->bind(':cp_street1', $data['cp_street1']);
        $this->db->bind(':cp_street2', $data['cp_street2']);
        $this->db->bind(':cp_city', $data['cp_city']);
        $this->db->bind(':cp_state', $data['cp_state']);
        $this->db->bind(':cp_zip_code', $data['cp_zip_code']);
        $this->db->bind(':cp_phone', $data['cp_phone']);
        $this->db->bind(':cp_fax', $data['cp_fax']);
        $this->db->bind(':cp_salutation', $data['cp_salutation']);
        $this->db->bind(':cp_f_name', $data['cp_f_name']);
        $this->db->bind(':cp_l_name', $data['cp_l_name']);
        $this->db->bind(':cp_email', $data['cp_email']);
        $this->db->bind(':cp_working_phone', $data['cp_working_phone']);
        $this->db->bind(':cp_mobile', $data['cp_mobile']);
        $this->db->bind(':gst', $data['gst']);
        $this->db->bind(':aadhar', $data['aadhar']);
        $this->db->bind(':passport', $data['passport']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':aniversary', $data['aniversary']);
        $this->db->bind(':blood', $data['blood']);
        $this->db->bind(':transport', $data['transport']);
        $this->db->bind(':cp', $data['cp']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function del_customer($id)
    {
        $this->db->query("DELETE FROM customer WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_single_customer($id)
    {
        $this->db->query("SELECT * FROM customer WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }

    public function save_distributor_details($data)
    {
        $this->db->query('INSERT INTO distributor(distributor_sa, distributor_first_name, distributor_last_name, distributor_name, distributor_display_name, distributor_email, distributor_phno_home, distributor_phno_work, distributor_website, currency, payment_terms, facebook, twitter, b_attention, b_country, b_street1, b_street2, b_city, b_state, b_zip_code, b_phone, b_fax, s_attention, s_country, s_street1, s_street2, s_city, s_state, s_zip_code, s_phone, s_fax, cp_salut, cp_first_name, cp_last_name, cp_email, cp_work_phone, cp_mobile
         ) VALUES(:salutation,:f_name,:l_name,:distributor_name,:c_display_name,:c_email,:Distributor_home_phone,:Distributor_work_phone,:website,:currency,:payment_terms,:facebook,:twitter,:attention,:country,:street1,:street2,:city,:state,:zip_code,:phone,:fax,:cp_attention,:cp_country,:cp_street1,:cp_street2,:cp_city,:cp_state,:cp_zip_code,:cp_phone,:cp_fax,:cp_salutation,:cp_f_name,:cp_l_name,:cp_email,:cp_working_phone,:cp_mobile)');

        $this->db->bind(':salutation', $data['salutation']);
        $this->db->bind(':f_name', $data['f_name']);
        $this->db->bind(':l_name', $data['l_name']);
        $this->db->bind(':distributor_name', $data['distributor_name']);
        $this->db->bind(':c_display_name', $data['c_display_name']);
        $this->db->bind(':c_email', $data['c_email']);
        $this->db->bind(':Distributor_home_phone', $data['Distributor_home_phone']);
        $this->db->bind(':Distributor_work_phone', $data['Distributor_work_phone']);
        $this->db->bind(':website', $data['website']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twitter', $data['twitter']);
        $this->db->bind(':attention', $data['attention']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':cp_attention', $data['cp_attention']);
        $this->db->bind(':cp_country', $data['cp_country']);
        $this->db->bind(':cp_street1', $data['cp_street1']);
        $this->db->bind(':cp_street2', $data['cp_street2']);
        $this->db->bind(':cp_city', $data['cp_city']);
        $this->db->bind(':cp_state', $data['cp_state']);
        $this->db->bind(':cp_zip_code', $data['cp_zip_code']);
        $this->db->bind(':cp_phone', $data['cp_phone']);
        $this->db->bind(':cp_fax', $data['cp_fax']);
        $this->db->bind(':cp_salutation', $data['cp_salutation']);
        $this->db->bind(':cp_f_name', $data['cp_f_name']);
        $this->db->bind(':cp_l_name', $data['cp_l_name']);
        $this->db->bind(':cp_email', $data['cp_email']);
        $this->db->bind(':cp_working_phone', $data['cp_working_phone']);
        $this->db->bind(':cp_mobile', $data['cp_mobile']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_all_distributor()
    {
        $this->db->query("SELECT * FROM distributor");
        return $results = $this->db->resultSet();
    }
    public function get_single_distributor($id)
    {
        $this->db->query("SELECT * FROM distributor WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function del_distributor($id)
    {
        $this->db->query("DELETE FROM distributor WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_distributor_details($data)
    {
        $this->db->query('UPDATE distributor SET distributor_sa=:salutation,distributor_first_name=:f_name,distributor_last_name=:l_name,distributor_name=:distributor_name,distributor_display_name=:c_display_name,distributor_email=:c_email,distributor_phno_home=:distributor_home_phone,distributor_phno_work=:distributor_work_phone,distributor_website=:website,currency=:currency,payment_terms=:payment_terms,facebook=:facebook,twitter=:twitter,b_attention=:attention,b_country=:country,b_street1=:street1,b_street2=:street2,b_city=:city,b_state=:state,b_zip_code=:zip_code,b_phone=:phone,b_fax=:fax,s_attention=:cp_attention,s_country=:cp_country,s_street1=:cp_street1,s_street2=:cp_street2,s_city=:cp_city,s_state=:cp_state,s_zip_code=:cp_zip_code,s_phone=:cp_phone,s_fax=:cp_fax,cp_salut=:cp_salutation,cp_first_name=:cp_f_name,cp_last_name=:cp_l_name,cp_email=:cp_email,cp_work_phone=:cp_working_phone,cp_mobile=:cp_mobile WHERE id = :id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':salutation', $data['salutation']);
        $this->db->bind(':f_name', $data['f_name']);
        $this->db->bind(':l_name', $data['l_name']);
        $this->db->bind(':distributor_name', $data['distributor_name']);
        $this->db->bind(':c_display_name', $data['c_display_name']);
        $this->db->bind(':c_email', $data['c_email']);
        $this->db->bind(':distributor_home_phone', $data['distributor_home_phone']);
        $this->db->bind(':distributor_work_phone', $data['distributor_work_phone']);
        $this->db->bind(':website', $data['website']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twitter', $data['twitter']);
        $this->db->bind(':attention', $data['attention']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':cp_attention', $data['cp_attention']);
        $this->db->bind(':cp_country', $data['cp_country']);
        $this->db->bind(':cp_street1', $data['cp_street1']);
        $this->db->bind(':cp_street2', $data['cp_street2']);
        $this->db->bind(':cp_city', $data['cp_city']);
        $this->db->bind(':cp_state', $data['cp_state']);
        $this->db->bind(':cp_zip_code', $data['cp_zip_code']);
        $this->db->bind(':cp_phone', $data['cp_phone']);
        $this->db->bind(':cp_fax', $data['cp_fax']);
        $this->db->bind(':cp_salutation', $data['cp_salutation']);
        $this->db->bind(':cp_f_name', $data['cp_f_name']);
        $this->db->bind(':cp_l_name', $data['cp_l_name']);
        $this->db->bind(':cp_email', $data['cp_email']);
        $this->db->bind(':cp_working_phone', $data['cp_working_phone']);
        $this->db->bind(':cp_mobile', $data['cp_mobile']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function add_sales_order_details($data)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }
        $this->db->query('INSERT INTO sales(customer_name, customer_id, sales_order, reference, ndate, expected_delivery_date, payment_terms, delivery_method, salesperson, customer_notes, t_and_c, img, temp_id, total_amount,state_for_tax,warehouse_name) VALUES(:customer, :customer_id, :sales_order, :reference, :ndate, :expected_delivery_date,:payment_terms, :delivery_method, :salesperson, :customer_notes, :t_and_c, :attachment, :tempId, :totalAmount,:state_for_tax,:warehouse_name)');
        // Bind values
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':sales_order', $data['sales_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':tempId', $data['tempId']);
        $this->db->bind(':totalAmount', $data['total_amount']);
        $this->db->bind(':state_for_tax',$data['state_for_tax']);
        $this->db->bind(':warehouse_name',$data['warehouse_name']);

        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM sales WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            return $this->db->single();
        } else {
            die('Error');
        }
    }
    public function make_order_sales_order_details($data)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }
        $this->db->query('INSERT INTO sales(customer_name, customer_id, sales_order, reference, ndate, expected_delivery_date, payment_terms, delivery_method, salesperson, customer_notes, t_and_c, img, temp_id, total_amount,state_for_tax,warehouse_name,status) VALUES(:customer, :customer_id, :sales_order, :reference, :ndate, :expected_delivery_date,:payment_terms, :delivery_method, :salesperson, :customer_notes, :t_and_c, :attachment, :tempId, :totalAmount,:state_for_tax,:warehouse_name,:status)');
        // Bind values
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':sales_order', $data['sales_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':tempId', $data['tempId']);
        $this->db->bind(':totalAmount', $data['total_amount']);
        $this->db->bind(':state_for_tax',$data['state_for_tax']);
        $this->db->bind(':warehouse_name',$data['warehouse_name']);
        $this->db->bind(':status',2);

        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM sales WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            return $this->db->single();
        } else {
            die('Error');
        }
    }
   

    public function add_distributor_order_details($data)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }
        $this->db->query('INSERT INTO sdistributor(distributor_name, distributor_id, distributor_order, reference, ndate, expected_delivery_date, payment_terms, delivery_method, salesperson, customer_notes, t_and_c, img, temp_id, total_amount,state_for_tax,warehouse_name) VALUES(:distributor_name, :distributor_id, :distributor_order, :reference, :ndate, :expected_delivery_date,:payment_terms, :delivery_method, :salesperson, :customer_notes, :t_and_c, :attachment, :tempId, :totalAmount,:state_for_tax,:warehouse_name)');
        // Bind values
        $this->db->bind(':distributor_name',$data['distributor']);
        $this->db->bind(':distributor_id', $data['distributor_id']);
        $this->db->bind(':distributor_order', $data['distributor_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':tempId', $data['tempId']);
        $this->db->bind(':totalAmount', $data['total_amount']);
        $this->db->bind(':state_for_tax',$data['state_for_tax']);
        $this->db->bind(':warehouse_name',$data['warehouse_name']);

        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM sdistributor WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            return $this->db->single();
        } else {
            die('Error');
        }
    }
    public function add_delivery_challan_order_details($data)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }


        $this->db->query('INSERT INTO delivery_challan(customer_name, customer_id, delivery_challan_no, reference, ndate, challan_type, customer_notes, t_and_c, img, temp_id, total_amount,warehouse_name) VALUES(:customer, :customer_id, :delivery_challan_no, :reference, :ndate, :challan_type, :customer_notes, :t_and_c, :attachment, :tempId, :totalAmount,:warehouse_name)');
        // Bind values
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':delivery_challan_no', $data['delivery_challan_no']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':challan_type', $data['challan_type']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':tempId', $data['tempId']);
        $this->db->bind(':totalAmount', $data['total_amount']);
        $this->db->bind(':warehouse_name',$data['warehouse_name']);

        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM delivery_challan WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            return $this->db->single();
        } else {
            die('Error');
        }
    }

    public function get_all_sales_order($lim, $off)
    {
        $this->db->query("SELECT * FROM sales ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
     public function get_all_customer_details($lim, $off)
    {
        $this->db->query("SELECT * FROM customer ORDER BY customer_first_name ASC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_all_sales_stock_out($lim, $off)
    {
        $this->db->query("SELECT * FROM stock_out ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_all_stock_out_order_for_pending($id)
    {
        $this->db->query("SELECT * FROM stock_out_order WHERE stock_out_id=:id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
     public function get_all_stock_out_package_stock_out_for_pending($id)
    {
        $this->db->query("SELECT * FROM stock_out_package WHERE stock_out_id=:id ORDER BY st_id DESC");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }

    public function get_all_dist_order($lim, $off)
    {
        $this->db->query("SELECT * FROM sdistributor ORDER BY id LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
     public function get_all_Delivery_challan_order($lim, $off)
    {
        $this->db->query("SELECT * FROM delivery_challan ORDER BY id LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function update_stock_convert($id,$aa,$box_qty,$pieces)
    {
        $a=$b=$c=$d=0;
        $this->db->query('SELECT * FROM stock WHERE id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();

        $a = $x->stock_on_hand - $pieces;
        $b = $x->remaining_stock;
        $c = $x->stock_total_receive - $pieces;
        $d = $x->total_qty_order;
        $this->db->query('UPDATE stock SET stock_on_hand=:stock_on_hand,remaining_stock=:remaining_stock,stock_total_receive=:stock_total_receive,total_qty_order=:total_qty_order,receivable=1 WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':stock_on_hand', $a);
        $this->db->bind(':remaining_stock', $b);
        $this->db->bind(':stock_total_receive', $c);
        $this->db->bind(':total_qty_order', $d);
        // Execute
        if ($this->db->execute()) 
        {
            $a=$b=$c=$d=0;
            $a=(int)$pieces * (int)$box_qty;
            $b=(int)$pieces * (int)$box_qty;
            $c=(int)$pieces * (int)$box_qty;
            $d=(int)$pieces * (int)$box_qty;
            for ($i=0; $i<$a; $i++) 
            {
                $this->db->query('INSERT INTO stock(name,vendor_name_id,order_number,batch, stock_on_hand, remaining_stock, stock_total_receive,total_qty_order,item_id, Expected_date,position,created_at,barcode,receivable,stock_id_for_refer) VALUES (:name,:vendor_name_id,:order_number,:batch,:stock_on_hand,:remaining_stock,:stock_total_receive,:total_qty_order,:item_id,:Expected_date,:position,:created_at,:barcode,:receivable,:stock_id_for_refer)');
                $this->db->bind(':name', $x->name);
                $this->db->bind(':vendor_name_id',$x->vendor_name_id);
                $this->db->bind(':order_number', $x->order_number);
                $this->db->bind(':batch', $x->batch);
                $this->db->bind(':stock_on_hand', 1);
                $this->db->bind(':remaining_stock', 0);
                $this->db->bind(':stock_total_receive', 1);
                $this->db->bind(':total_qty_order', 1);
                $this->db->bind(':item_id', $x->item_id);
                $this->db->bind(':Expected_date', $x->Expected_date);
                $this->db->bind(':created_at', $x->created_at);
                $this->db->bind(':position', $x->position);
                $this->db->bind(':receivable', 3);
                $this->db->bind(':barcode', $x->barcode);
                $this->db->bind(':stock_id_for_refer', $id);
                $this->db->execute();
            }
            return true;

        } 
        else 
        {
            return false;
        }
    }
    public function update_sales_order_details($data)
    {
        if (!empty($_FILES['files']['name'])) {
            $f_name = $_FILES['files']['name'];
            $f_temp = $_FILES['files']['tmp_name'];
            $size = $_FILES['files']['size'];
            $f_extension = explode('.', $f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid() . '.' . $f_extension;
            $store = "uploads/" . $f_newfile;
            move_uploaded_file($f_temp, $store);
            $store = "uploads/";
            $_SESSION['attachment'] = $f_newfile;
        } else {
            $_SESSION['attachment'] = "not supported file";
        }


        $this->db->query('UPDATE sales SET customer_name=:customer,customer_id=:customer_id,sales_order=:sales_order,reference=:reference,ndate=:ndate,expected_delivery_date=:expected_delivery_date,payment_terms=:payment_terms,delivery_method=:delivery_method,salesperson=:salesperson,product=:product,qty=:qty,price=:price,total=:total,sub_total=:sub_total,tax=:tax,tax_amount=:tax_amount,total_amount=:total_amount,customer_notes=:customer_notes,t_and_c=:t_and_c,img=:attachment,total_qty=:total_qty,total_rem=:total_qty WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':sales_order', $data['sales_order']);
        $this->db->bind(':reference', $data['reference']);
        $this->db->bind(':ndate', $data['ndate']);
        $this->db->bind(':expected_delivery_date', $data['expected_delivery_date']);
        $this->db->bind(':payment_terms', $data['payment_terms']);
        $this->db->bind(':delivery_method', $data['delivery_method']);
        $this->db->bind(':salesperson', $data['salesperson']);
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':tax', $data['tax']);
        $this->db->bind(':tax_amount', $data['tax_amount']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':customer_notes', $data['customer_notes']);
        $this->db->bind(':t_and_c', $data['t_and_c']);
        $this->db->bind(':attachment', $_SESSION['attachment']);
        $this->db->bind(':total_qty', $data['total_qty']);
        $this->db->bind(':total_rem', $data['total_qty']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_single_sales($id)
    {
        $this->db->query("SELECT * FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function del_sales($id)
    {
        $this->db->query("DELETE FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_all_distributor_order()
    {
        $this->db->query("SELECT * FROM sdistributor");
        return $results = $this->db->resultSet();
    }
    public function del_distributor_order($id)
    {
        $this->db->query("DELETE FROM sdistributor WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // all code from preetham, following from saturday

    public function saveCategoryDb_for_type($cName)
    {
        $this->db->query('INSERT INTO types (type_name) VALUES(:cName)');
        $this->db->bind(':cName', $cName);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function savecolor($cName)
    {
        $this->db->query('INSERT INTO color (color_name) VALUES(:cName)');
        $this->db->bind(':cName', $cName);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function savemfg($cName)
    {
        $this->db->query('INSERT INTO manufacturer (mfg_name) VALUES(:cName)');
        $this->db->bind(':cName', $cName);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function savesize($cName)
    {
        $this->db->query('INSERT INTO size (size_name) VALUES(:cName)');
        $this->db->bind(':cName', $cName);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }

    public function saveCategoryDb($cName)
    {
        $this->db->query('INSERT INTO category (category_name) VALUES(:cName)');
        $this->db->bind(':cName', $cName);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }

    public function checkForDuplicateCategory($cName)
    {
        $this->db->query('SELECT category_id FROM category WHERE category_name = :cName');
        $this->db->bind(':cName', $cName);
        $this->db->single();
        return $this->db->rowCount();
    }

    public function getAllCategories($lim, $off)
    {
        $this->db->query('SELECT * FROM category LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
     public function getalltypes_for_all($lim, $off)
    {
        $this->db->query('SELECT * FROM types LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
    public function getAllCategoriesDb()
    {
        $this->db->query('SELECT * FROM category');
        return $this->db->resultSet();
    }
    public function getAllCategoriesDb_new()
    {
        $this->db->query('SELECT * FROM category_new');
        return $this->db->resultSet();
    }
     public function getAllsubCategoriesDb_new()
    {
        $this->db->query('SELECT * FROM sub_category_new');
        return $this->db->resultSet();
    }
     public function getAllcolorDb_new()
    {
        $this->db->query('SELECT * FROM color');
        return $this->db->resultSet();
    }
     public function getAllmfg()
    {
        $this->db->query('SELECT * FROM manufacturer');
        return $this->db->resultSet();
    }
     public function getAllsizeDb_new()
    {
        $this->db->query('SELECT * FROM size');
        return $this->db->resultSet();
    }

    public function getAllCategoriesDb_model()
    {
        $this->db->query('SELECT * FROM model');
        return $this->db->resultSet();
    }
    public function getAlltypeDb()
    {
        $this->db->query('SELECT * FROM types');
        return $this->db->resultSet();
    }
    public function getAllCategoriesDb2()
    {
        $this->db->query('SELECT * FROM sub_category');
        return $this->db->resultSet();
    }
    public function getAllCategoriesDb3()
    {
        $this->db->query('SELECT * FROM sub_category2');
        return $this->db->resultSet();
    }
    public function getAllCategoriesDb4()
    {
        $this->db->query('SELECT * FROM sub_category3');
        return $this->db->resultSet();
    }

     public function saveSC_for_model($sCName, $cId)
    {
        $this->db->query('INSERT INTO model (model_name, type_id) VALUES(:sCName, :cId)');
        $this->db->bind(':sCName', $sCName);
        $this->db->bind(':cId', $cId);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function saveSC($sCName, $cId)
    {
        $this->db->query('INSERT INTO sub_category (sc_name, category_id) VALUES(:sCName, :cId)');
        $this->db->bind(':sCName', $sCName);
        $this->db->bind(':cId', $cId);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
     public function getmfgsingle($cId)
    {
        $this->db->query('SELECT * FROM manufacturer WHERE mfg_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn;
    }
    public function checkForTheSubCategory($sCName, $cId)
    {
        $this->db->query('SELECT sc_id FROM sub_category WHERE sc_name = :sCName AND category_id = :cId');
        $this->db->bind(':sCName', $sCName);
        $this->db->bind(':cId', $cId);
        $this->db->single();
        return $this->db->rowCount();
    }

    public function getAllSubCategories($lim, $off)
    {
        $this->db->query('SELECT * FROM sub_category LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }

    public function getCategoryName($cId)
    {
        $this->db->query('SELECT category_name FROM category WHERE category_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn->category_name;
    }
    public function getsubcatName1($cId)
    {
        $this->db->query('SELECT sc_name FROM sub_category WHERE sc_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn->sc_name;
    }
    public function getsubcatName22($cId)
    {
        $this->db->query('SELECT sc2_name FROM sub_category2 WHERE sc2_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn->sc2_name;
    }
    public function getsubcatName33($cId)
    {
        $this->db->query('SELECT sc3_name FROM sub_category3 WHERE sc3_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn->sc3_name;
    }

    public function getSubCategoryByCategoryId($categoryId)
    {
        $this->db->query('SELECT * FROM sub_category WHERE category_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        return  $this->db->resultSet();
    }
     public function getmodels_by_id($categoryId)
    {
        $this->db->query('SELECT * FROM model WHERE type_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        return  $this->db->resultSet();
    }
     public function getcategory_new_by_id($categoryId)
    {
        $this->db->query('SELECT * FROM category_new WHERE model_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        return  $this->db->resultSet();
    }
    public function getcategory_new_by_id_c($categoryId)
    {
        $this->db->query('SELECT * FROM category_new WHERE model_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        return  $this->db->resultSet();
    }
     public function getsubcategory_new_by_id($categoryId)
    {
        $this->db->query('SELECT * FROM sub_category_new WHERE category_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        return  $this->db->resultSet();
    }

    public function getSubCategoryByCategoryId1($categoryId1)
    {
        $this->db->query('SELECT * FROM sub_category2 WHERE sub_category_id = :categoryId1');
        $this->db->bind(':categoryId1', $categoryId1);
        return  $this->db->resultSet();
    }
    public function getSubCategoryByCategoryId2($categoryId1)
    {
        $this->db->query('SELECT * FROM sub_category3 WHERE sub_category2_id = :categoryId1');
        $this->db->bind(':categoryId1', $categoryId1);
        return  $this->db->resultSet();
    }

    public function getAllItems($tags)
    {
        $this->db->query('SELECT * FROM items WHERE name LIKE concat("%", :tags, "%") LIMIT 5');
        $this->db->bind(':tags', $tags);
        return $this->db->resultSet();
    }

    public function getTheItemDetails($val)
    {
        $this->db->query('SELECT * FROM items WHERE id = :val');
        $this->db->bind(':val', $val);
        return $this->db->single();
    }
    public function get_all_companydetails()
    {
        $this->db->query("SELECT * FROM company_details");
        return $results = $this->db->resultSet();
    }

    public function getReceivableForTheItemDb($iId)
    {
        $this->db->query('SELECT receive, qty, purchase_price FROM items WHERE id = :iId');
        $this->db->bind(':iId', $iId);
        return $this->db->single();
    }

    public function saveTheTempData($item_id,$item, $receivable, $perUnitQty, $actQty, $totalQty, $rowPrice, $rowTotal)
    {
        $this->db->query('INSERT INTO temp_data (ItemID,item, receivable, per_unit_qty, act_qty, total_qty, row_price, row_total,created_by) VALUES(:item_id,:item, :receivable, :perUnitQty, :actQty, :totalQty, :rowPrice, :rowTotal, :created_by)');
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':item', $item);
        $this->db->bind(':receivable', $receivable);
        $this->db->bind(':perUnitQty', $perUnitQty);
        $this->db->bind(':actQty', $actQty);
        $this->db->bind(':totalQty', $totalQty);
        $this->db->bind(':rowPrice', $rowPrice);
        $this->db->bind(':rowTotal', $rowTotal);
        $this->db->bind(':created_by',$_SESSION['user_id']);
        $this->db->execute();
        return true;
    }

    public function getTheRowCount()
    {
        $this->db->query('SELECT temp_id FROM temp_data WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function get_temp_nonpurchasedb_count()
    {
        $this->db->query('SELECT * FROM temp_non_purchase WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
    public function check_temp_data_count()
    {
        $this->db->query('SELECT * FROM temp_data WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
    public function get_count_sales_order()
    {
        $this->db->query('SELECT * FROM temp_sale WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
     public function get_count_temp_stock_out_order()
    {
        $this->db->query('SELECT * FROM temp_stock_out WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
    


    public function saveThePurchaseOrderItemDetails($tId, $data)
    {
        $this->db->query('SELECT * FROM temp_data WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $allItems = $this->db->resultSet();


        // arrays for storing
        $itemNameArray = array();
        $itemIdArray = array();
        $receivableArray = array();
        $perUnitArray = array();
        $actArray = array();
        $totalArray = array();
        $rowPriceArray = array();
        $rowTotal = array();

        foreach ($allItems as $key) {
            // $i = explode('(', $key->item);
            // $id = explode(')', $i[1]);

            array_push($itemNameArray, $key->item);
            array_push($itemIdArray, $key->ItemID);
            array_push($receivableArray, $key->receivable);
            array_push($perUnitArray, $key->per_unit_qty);
            array_push($actArray, $key->act_qty);
            array_push($totalArray, $key->total_qty);
            array_push($rowPriceArray, $key->row_price);
            array_push($rowTotal, $key->row_total);
        }

        $this->db->query('INSERT INTO purchase_order (item_id, item_name, receivable, per_unit_quantity, act_qty, total_qty, row_price, row_total, purchase_ref_id, subtotal, po_tax, po_tax_amount, po_discount, discount_amount, grand_total) VALUES(:itemIdArray, :itemNameArray, :receivableArray, :perUnitArray, :actArray, :totalArray, :rowPriceArray, :rowTotal, :tId, :sub_total, :tax, :tax_amount, :discount, :discount_amount, :total_amount)');
        $this->db->bind(':itemIdArray', implode('|||', $itemIdArray));
        $this->db->bind(':itemNameArray', implode('|||', $itemNameArray));
        $this->db->bind(':receivableArray', implode('|||', $receivableArray));
        $this->db->bind(':perUnitArray', implode('|||', $perUnitArray));
        $this->db->bind(':actArray', implode('|||', $actArray));
        $this->db->bind(':totalArray', implode('|||', $totalArray));
        $this->db->bind(':rowPriceArray', implode('|||', $rowPriceArray));
        $this->db->bind(':rowTotal', implode('|||', $rowTotal));
        $this->db->bind(':tId', $tId);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':tax', $data['tax']);
        $this->db->bind(':discount', $data['discount']);
        $this->db->bind(':discount_amount', $data['discount_amount']);
        $this->db->bind(':tax_amount', $data['tax_amount']);
        $this->db->bind(':total_amount', $data['total_amount']);
        if ($this->db->execute()) {
            $this->db->query('DELETE FROM temp_data WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        } else {
            die('Error');
        }
    }

    public function deleteAllTempData()
    {
        $this->db->query('DELETE FROM temp_data WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
        return true;
    }
    public function clear_all_tempnon_purchase()
    {
        $this->db->query('DELETE FROM temp_non_purchase WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
        return true;
    }
     public function delete_all_temp_sale()
    {
        $this->db->query('DELETE FROM temp_sale WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
        return true;
    }


    public function getAllThePo($lim, $off)
    {
        $this->db->query('SELECT * FROM purchase ORDER BY id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function getThePurchaseDetails($pid)
    {
        $this->db->query('SELECT * FROM purchase WHERE id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }

    public function getThePurchaseItemDetails($pid)
    {
        $this->db->query('SELECT * FROM purchase_order WHERE purchase_ref_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }

    public function saveTheReceiveDb($batch, $itemId, $itemName, $receivable, $rQty, $rPerQty, $notes, $pid, $position,$barcode)
    {

        $this->db->query('INSERT INTO receive_item (purchase_order_id, item_id, item_name, received_qty, received_per_qty, receivable, batch, notes, position,barcode) VALUES(:pid, :itemId, :itemName, :rQty, :rPerQty, :receivable, :batch, :notes, :position,:barcode)');
        $this->db->bind(':pid', $pid);
        $this->db->bind(':itemId', $itemId);
        $this->db->bind(':itemName', $itemName);
        $this->db->bind(':rQty', $rQty);
        $this->db->bind(':rPerQty', $rPerQty);
        $this->db->bind(':receivable', $receivable);
        $this->db->bind(':batch', $batch);
        $this->db->bind(':notes', $notes);
        $this->db->bind(':position', $position);
        $this->db->bind(':barcode', $barcode);
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM receive_item_draft where p_id = :pid');
            $this->db->bind(':pid', $pid);
            $this->db->execute();
            return true;
        }
         else {
            die("Error");
        }
    }
    public function saveTheReceiveDb1($batch, $itemId, $itemName, $receivable, $rQty, $rPerQty, $notes, $position)
    {
        $this->db->query('INSERT INTO receive_item (item_id, item_name, received_qty, received_per_qty, receivable, batch, notes, position) VALUES(:itemId, :itemName, :rQty, :rPerQty, :receivable, :batch, :notes, :position)');
        $this->db->bind(':itemId', $itemId);
        $this->db->bind(':itemName', $itemName);
        $this->db->bind(':rQty', $rQty);
        $this->db->bind(':rPerQty', $rPerQty);
        $this->db->bind(':receivable', $receivable);
        $this->db->bind(':batch', $batch);
        $this->db->bind(':notes', $notes);
        $this->db->bind(':position', $position);

        if ($this->db->execute()) {
            return true;
        } else {
            die("Error");
        }
    }
    public function receiveThePurchase($pid)
    {
        $this->db->query('SELECT * FROM receive_item WHERE purchase_order_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->resultSet();
    }

    public function getTheReceivedDetails($pid)
    {
        $this->db->query('SELECT * FROM receive_item WHERE purchase_order_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->resultSet();
    }

    public function getTheReceiveDetails($rId)
    {
        $this->db->query('SELECT * FROM receive_item WHERE receive_id = :rId');
        $this->db->bind(':rId', $rId);
        return $this->db->single();
    }

    public function saveTheBillDb($itemId, $itemName, $qty, $price, $total, $subTotal, $tax, $taxAmount, $discount, $discountAmount, $totalAmount, $pid, $rid)
    {
        $this->db->query('INSERT INTO bills (purchase_id, receive_id, item_id, item_name, qty, item_price, item_total, tax, tax_amount, discount, discount_amount, grand_total) VALUES(:pid, :rid, :itemId, :itemName, :qty, :price, :subTotal, :tax, :taxAmount, :discount, :discountAmount, :totalAmount)');
        $this->db->bind(':pid', $pid);
        $this->db->bind(':rid', $rid);
        $this->db->bind(':itemId', $itemId);
        $this->db->bind(':itemName', $itemName);
        $this->db->bind(':qty', $qty);
        $this->db->bind(':price', $price);
        $this->db->bind(':subTotal', $subTotal);
        $this->db->bind(':tax', $tax);
        $this->db->bind(':taxAmount', $taxAmount);
        $this->db->bind(':discount', $discount);
        $this->db->bind(':discountAmount', $discountAmount);
        $this->db->bind(':totalAmount', $totalAmount);

        if ($this->db->execute()) {
            $this->db->query('UPDATE receive_item SET status = 1 WHERE receive_id = :rid');
            $this->db->bind(':rid', $rid);
            $this->db->execute();
            return true;
        } else {
            die('Error');
        }
    }

    public function getTheBillsDb($pid)
    {
        $this->db->query('SELECT * FROM bills WHERE purchase_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->resultSet();
    }
    public function get_single_bill_from_id($id)
    {
        $this->db->query("SELECT * FROM bills WHERE bill_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function purchase_single_order_details($pid)
    {
        $this->db->query('SELECT * FROM purchase_order WHERE purchase_ref_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function purchase_single_details($pid)
    {
        $this->db->query('SELECT * FROM purchase WHERE id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function save_stock_with_batch($pid, $batch, $receive_qty, $rem, $items, $total_qty, $name, $expected_date, $position, $rec_date,$barcode,$receivable,$b1,$b2,$b3,$b4,$b5,$b6,$b7,$b8,$b9,$b10)
    {
        $rec_date = date('Y-m-d',strtotime($rec_date));
        $r1 = array();           
        $temp_size = explode('|||',$items);
        $items = explode('|||',$items);
        $receive_qty = explode('|||',$receive_qty);
        $rem = explode('|||',$rem);
        $total_qty = explode('|||',$total_qty);
        $position = explode('|||',$position);
        $barcode = explode('|||', $barcode);
        $receivable = explode("|||", $receivable);
        $r ='';
        for ($i = 0; $i < sizeof($temp_size); $i++) 
        { 
            $r ='';
            $r = $pid.$items[$i].rand(0,99999);
            for ($h=0; $h <$receive_qty[$i]; $h++) 
            { 
                
                $this->db->query('INSERT INTO stock(name,order_number,batch, stock_on_hand, remaining_stock, stock_total_receive,total_qty_order,item_id, Expected_date,position,created_at,barcode,receivable,temp_qr_id) VALUES (:name,:pid,:batch,:receive_qty,:rem,:receive_qty,:total_qty,:items,:expected_date,:position,:rec_date,:barcode,:receivable,:temp_qr_id)');
                $this->db->bind(':name', $name);
                $this->db->bind(':pid', $pid);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':receive_qty', 1);
                $this->db->bind(':rem', 0);
                $this->db->bind(':items', $items[$i]);
                $this->db->bind(':total_qty', $total_qty[$i]);
                $this->db->bind(':expected_date', $expected_date);
                $this->db->bind(':position', $position[$i]);
                $this->db->bind(':rec_date', $rec_date);
                $this->db->bind(':barcode', $barcode[$i]);
                $this->db->bind(':receivable', $receivable[$i]);
                $this->db->bind(':temp_qr_id',$r);
                $result = $this->db->execute();
            }
                   
            $r1[] = $r;
            $this->db->query('SELECT * FROM items WHERE id = :itemId');
            $this->db->bind(':itemId', $items[$i]);
            $it = $this->db->single();
            if(!empty($it))
            {
                 $temp_it =  $it->available_stock;
                $temp_it = $temp_it + $receive_qty[$i];
                $this->db->query('UPDATE items SET available_stock =:temp_it WHERE id =:itemId');
                $this->db->bind(':itemId', $items[$i]);
                $this->db->bind(':temp_it', $temp_it);
                $this->db->execute();
            }
           
        }
        $r1 = implode('|||', $r1);
        if ($result) 
        {
                    $b11 = $b1;
                    $b22 = $b2; 
                    $b33 = $b3;
                    $b44 = $b4;
                    $b55 = $b5;
                    $b66 = $b6; 
                    $b77 = $b7; 
                    $b88 = $b8;
                    $b99 = $b9;
                    $b1010 = $b10;

            $this->db->query('INSERT INTO receive_item (purchase_order_id, item_id, item_name, received_qty, received_per_qty, receivable, batch, notes, position,barcode,temp_for_qr,received_date_time) VALUES(:pid, :itemId, :itemName, :rQty, :rPerQty, :receivable, :batch, :notes, :position,:barcode,:temp_for_qr,:rec_date)');
            $this->db->bind(':pid', $b88);
            $this->db->bind(':itemId', $b22);
            $this->db->bind(':itemName', $b33);
            $this->db->bind(':rQty', $b55);
            $this->db->bind(':rPerQty', $b66);
            $this->db->bind(':receivable', $b44);
            $this->db->bind(':batch', $b11);
            $this->db->bind(':notes', $b77);
            $this->db->bind(':position', $b99);
            $this->db->bind(':barcode', $b1010);
            $this->db->bind(':temp_for_qr',$r1);
            $this->db->bind(':rec_date', $rec_date);
            $this->db->execute();
            return true;
        } else {  
            die("Error");
        }
    }
     public function save_stock_with_batch1($receive_qty, $rem, $items, $total_qty, $position,$batch,$rec_date,$barcode,$vendor_name,$vendor_id,$receivable,$notes)
    {   
        $temp_qr_print_all = 0;
        $temp_qr_id = array();
        $itemid = array();
        $rQty = array();
        $itemName = array();
        $typeforQR = array();
        $this->db->query('SELECT * FROM temp_non_purchase WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $tm_data =  $this->db->resultSet();
        $yq=0;
        $yq = $yq.rand(10,999).$yq.rand(19,999);
        $r = '';
        foreach ($tm_data as $k) 
        {
            $r ='';
            $r = $k->item_id.rand(0,999999);
            for ($i=0; $i<$k->qty; $i++) 
            { 
                $this->db->query('INSERT INTO stock(batch, stock_on_hand, remaining_stock, stock_total_receive, total_qty_order, item_id, Expected_date, created_at, position, barcode,name,vendor_name_id,receivable,temp_qr_id,temp_qr_print_all) VALUES (:batch,:receive_qty,:rem,:receive_qty,:receive_qty,:items,:rec_date,:rec_date,:position,:barcode,:vendor_name,:vendor_id,:receivable,:r,:temp_qr_print_all)');
                $this->db->bind(':receive_qty', 1);
                $this->db->bind(':rem', 0);
                $this->db->bind(':items', $k->item_id);
                $this->db->bind(':position', $k->position);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':rec_date', $rec_date);
                $this->db->bind(':barcode', $barcode);
                $this->db->bind(':vendor_name', $vendor_name);
                $this->db->bind(':vendor_id', $vendor_id);
                $this->db->bind(':receivable', $k->receivable);
                $this->db->bind(':r', $r);
                $this->db->bind(':temp_qr_print_all', $yq);
                $x = $this->db->execute();
            }
                $this->db->query('INSERT INTO nonpurchase(vendor,vendor_id,receive_date,batch,item_id,receivable,qty_receive,positions,barcode,notes,non_purchase_id_temp,temp_qr_print_all) VALUES (:vendor_name,:vendor_id,:rec_date,:batch,:items,:receivable,:receive_qty,:position,:barcode,:notes,:r,:temp_qr_print_all)');
                $this->db->bind(':receive_qty', $k->qty);
                $this->db->bind(':items', $k->item_id);
                $this->db->bind(':position', $k->position);
                $this->db->bind(':batch', $batch);
                $this->db->bind(':rec_date', $rec_date);
                $this->db->bind(':barcode', $barcode);
                $this->db->bind(':vendor_name', $vendor_name);
                $this->db->bind(':vendor_id', $vendor_id);
                $this->db->bind(':receivable', $k->receivable);
                $this->db->bind(':notes', $notes);
                $this->db->bind(':r', $r);
                $this->db->bind(':temp_qr_print_all', $yq);
                $x = $this->db->execute();
                $typeforQR[] = $k->receivable;
                $this->db->query("SELECT * FROM items WHERE id = :id");
                $this->db->bind(':id', $k->item_id);
                $y = $results = $this->db->single();

                $temp_qr_id[] = $r;
                $itemid[] = $k->item_id;
                $rQty[] = $k->qty;
                $itemName[] = $y->name;
        }
        if ($x) 
        {
            $temp_qr_id = implode('|', $temp_qr_id);
            $itemid = implode('|', $itemid);
            $rQty = implode('|', $rQty);
            $itemName = implode('|', $itemName);
            $typeforQR = implode('|', $typeforQR);
            $data=[ 
                    'temp_qr_print_all' => $yq,
                    'temp_qr_id'=>$temp_qr_id,
                    'itemid'=>$itemid,
                    'rQty' => $rQty,
                    'itemName'=>$itemName,
                    'receivable_type' => $typeforQR
                  ];
            $this->db->query('DELETE FROM temp_non_purchase WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return $data;
        } else {
            die("Error");
        }
    }
     public function save_non_purchase_with_batch($receive_qty, $rem, $items, $total_qty, $position,$batch,$rec_date,$barcode,$vendor_name,$vendor_id,$receivable,$notes,$r)
    { 
        $this->db->query('SELECT * FROM temp_non_purchase WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $tm_data =  $this->db->resultSet();
        
        foreach ($tm_data as $k) 
        {
            $this->db->query('INSERT INTO nonpurchase(vendor,vendor_id,receive_date,batch,item_id,receivable,qty_receive,positions,barcode,notes,non_purchase_id_temp) VALUES (:vendor_name,:vendor_id,:rec_date,:batch,:items,:receivable,:receive_qty,:position,:barcode,:notes,:r)');
            $this->db->bind(':receive_qty', $k->qty);
            $this->db->bind(':items', $k->item_id);
            $this->db->bind(':position', $k->position);
            $this->db->bind(':batch', $batch);
            $this->db->bind(':rec_date', $rec_date);
            $this->db->bind(':barcode', $barcode);
            $this->db->bind(':vendor_name', $vendor_name);
            $this->db->bind(':vendor_id', $vendor_id);
            $this->db->bind(':receivable', $k->receivable);
            $this->db->bind(':notes', $notes);
            $this->db->bind(':r', $r);
            $x = $this->db->execute();
        }
        if($x) 
        {
            $this->db->query('DELETE FROM temp_non_purchase WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        } else {
            die("Error");
        }
    }

    public function saveThePositions($posCode, $posDetails)
    {
        $this->db->query('INSERT INTO positions (position_code, position_details) VALUES(:posCode, :posDetails)');
        $this->db->bind(':posCode', $posCode);
        $this->db->bind(':posDetails', $posDetails);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }

    public function getAllPositions($lim, $off)
    {
        $this->db->query('SELECT * FROM positions LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }

    public function getAllPOsitionsForReceive()
    {
        $this->db->query('SELECT * FROM positions');
        return $this->db->resultSet();
    }

    public function getTheCostPriceForTheItem($itemId)
    {
        $this->db->query('SELECT selling_price FROM items WHERE id = :itemId');
        $this->db->bind(':itemId', $itemId);
        return $this->db->single();
    }
     public function getTheqtyForTheItem($itemId)
    {
        $this->db->query('SELECT * FROM items WHERE id = :itemId');
        $this->db->bind(':itemId', $itemId);
        return $this->db->single();
    }
        public function getall_venders_by_tags($tags)
    {
        $this->db->query('SELECT * FROM vendor WHERE dispName LIKE concat("%", :tags, "%")');
        $this->db->bind(':tags', $tags);
        return $this->db->resultSet();
    }
    public function getSubCategoryByCategoryId_for_view($categoryId)
    {
        $this->db->query('SELECT * FROM sub_category WHERE sc_id = :categoryId');
        $this->db->bind(':categoryId', $categoryId);
        $cn = $this->db->single();
        return $cn->sc_name;
    }
     public function get_all_category($id)
    {
        $this->db->query('SELECT * FROM category WHERE category_id = :categoryId');
        $this->db->bind(':categoryId', $id);
        return $this->db->single();
    }
     public function getAlltypeDb_single($id)
    {
        $this->db->query('SELECT * FROM types WHERE type_id = :type_id');
        $this->db->bind(':type_id', $id);
        return $this->db->single();
    }
     public function updateCategoryDb($id,$cName)
    {
        $this->db->query('UPDATE category SET category_name =:cName WHERE category_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':cName', $cName);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function updatetypeDb($id,$cName)
    {
        $this->db->query('UPDATE types SET type_name =:cName WHERE type_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':cName', $cName);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function get_all_subcategory($id)
    {
        $this->db->query('SELECT * FROM sub_category WHERE sc_id = :sc_id');
        $this->db->bind(':sc_id', $id);
        return $this->db->single();
    }
     public function updatesubCategoryDb($id,$sc_name)
    {
        $this->db->query('UPDATE sub_category SET sc_name =:sc_name WHERE sc_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':sc_name', $sc_name);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function get_single_position($id)
    {
        $this->db->query('SELECT * FROM positions WHERE position_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function checkforduptax($tax)
    {
        $this->db->query('SELECT tax FROM tax WHERE tax = :tax');
        $this->db->bind(':tax', $tax);
        $this->db->single();
        return $this->db->rowCount();
    }
    public function savetax($tax)
    {
        $this->db->query('INSERT INTO tax (tax) VALUES(:tax)');
        $this->db->bind(':tax', $tax);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function saveTheSalesTempData($sta, $item_id, $sItem, $sQty, $sPrice, $sTax, $sTotal)
    {
        // $itemId = explode('(', $sItem);
        $name = $sItem;
        // $itemName = explode(')', $itemId[1]);
        $id = $item_id;

        $this->db->query('INSERT INTO temp_sale (item_id, item_name, s_qty, s_price, s_tax, s_total, s_state, created_by) VALUES(:id, :name, :sQty, :sPrice, :sTax, :sTotal, :sta, :user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $name);
        $this->db->bind(':sQty', $sQty);
        $this->db->bind(':sPrice', $sPrice);
        $this->db->bind(':sTax', $sTax);
        $this->db->bind(':sTotal', $sTotal);
        $this->db->bind(':sta', $sta);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveTheSalesTempData_stock_out($item_id,$item_name, $sQty, $rec,$price,$total)
    {
        // $itemId = explode('(', $sItem);
        // $name = $itemId[0];
        // $itemName = explode(')', $itemId[1]);
        // $id = $itemName[0];
        $this->db->query('INSERT INTO temp_stock_out (item_id, item_name, s_qty, type, price, total,created_by) VALUES(:id, :name, :sQty, :rec, :price, :total,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':id', $item_id);
        $this->db->bind(':name', $item_name);
        $this->db->bind(':sQty', $sQty);
        $this->db->bind(':rec', $rec);
        $this->db->bind(':price', $price);
        $this->db->bind(':total', $total);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function savetempnonpurchasedb($itemid, $item_name, $receive, $rqty, $position)
    {
        // $itemId = explode('(', $sItem);
        // $name = $itemId[0];
        // $itemName = explode(')', $itemId[1]);
        // $id = $itemName[0];

        $this->db->query('INSERT INTO temp_non_purchase(item_id, item_name, receivable, qty, position,created_by) VALUES (:item_id,:item_name,:receive,:rqty,:position,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $itemid);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':receive', $receive);
        $this->db->bind(':rqty', $rqty);
        $this->db->bind(':position', $position);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveThedistributorTempData($sta, $sItem, $sQty, $sPrice, $sTax, $sTotal)
    {
        $itemId = explode('(', $sItem);
        $name = $itemId[0];
        $itemName = explode(')', $itemId[1]);
        $id = $itemName[0];
        $this->db->query('INSERT INTO temp_distributor (item_id, item_name, s_qty, s_price, s_tax, s_total, s_state,created_by) VALUES(:id, :name, :sQty, :sPrice, :sTax, :sTotal, :sta, :created_by)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $name);
        $this->db->bind(':sQty', $sQty);
        $this->db->bind(':sPrice', $sPrice);
        $this->db->bind(':sTax', $sTax);
        $this->db->bind(':sTotal', $sTotal);
        $this->db->bind(':sta', $sta);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveThedeliverychallanTempData($sta, $sItem, $sQty, $sPrice, $sTax, $sTotal)
    {
        $itemId = explode('(', $sItem);
        $name = $itemId[0];
        $itemName = explode(')', $itemId[1]);
        $id = $itemName[0];
        $this->db->query('INSERT INTO temp_delivery_challan (item_id, item_name, s_qty, s_price, s_tax, s_total, s_state,created_by) VALUES(:id, :name, :sQty, :sPrice, :sTax, :sTotal, :sta,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $name);
        $this->db->bind(':sQty', $sQty);
        $this->db->bind(':sPrice', $sPrice);
        $this->db->bind(':sTax', $sTax);
        $this->db->bind(':sTotal', $sTotal);
        $this->db->bind(':sta', $sta);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function getTheTempSalesDataCount()
    {
        $this->db->query('SELECT id FROM temp_sale WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function getTheTempSalesDataCount_for_stock_out()
    {
        $this->db->query('SELECT id FROM temp_stock_out WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function getTheTempnon_purchase_count()
    {
        $this->db->query('SELECT id FROM temp_non_purchase WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function get_temp_sales_count()
    {
        $this->db->query('SELECT * FROM temp_sale WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }

     public function getTheTempDistDataCount()
    {
        $this->db->query('SELECT id FROM temp_distributor WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function getTheTempdeliverychallanDataCount()
    {
        $this->db->query('SELECT id FROM temp_delivery_challan WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
    public function getTheTax($itemId)
    {
        $this->db->query('SELECT gst, igst FROM items WHERE id = :itemId');
        $this->db->bind(':itemId', $itemId);
        return $this->db->single();
    }
    public function saveTheSalesOrderData($saleId)
    {
        $this->db->query('SELECT * FROM temp_sale WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        // arrays
        $itemIdArray = array();
        $itemNameArray = array();
        $qtyArray = array();
        $priceArray = array();
        $taxArray = array();
        $totalArray = array();
        $stateArray = array();
        $a=0;
        foreach ($row as $key)
        {
            $itemIdArray[] = $key->item_id;
            $itemNameArray[] = $key->item_name; 
            $qtyArray[] = $key->s_qty;
            $priceArray[] = $key->s_price;
            $taxArray[] = $key->s_tax;
            $totalArray[] = $key->s_total;
            $stateArray[] = $key->s_state;
            $this->db->query('SELECT * FROM items WHERE id = :id');
            $this->db->bind(':id', $key->item_id);
            $x = $this->db->single();
            $a = $x->committed_stock;
            $a = $a + $key->s_qty;
            // $this->db->query('UPDATE items SET committed_stock = :sqty WHERE id = :item_id');
            // $this->db->bind(':item_id', $key->item_id);
            // $this->db->bind(':sqty',  $a);
            // $this->db->execute();    
        }

        $this->db->query('INSERT INTO sale_order (item_id, sale_id, item_name, item_qty, item_price, item_tax, item_total, item_state) VALUES(:itemId, :saleId, :itemName, :qty, :price, :tax, :total, :state)');
        $this->db->bind(':saleId', $saleId);
        $this->db->bind(':itemId', implode('|||', $itemIdArray));
        $this->db->bind(':itemName', implode('|||', $itemNameArray));
        $this->db->bind(':qty', implode('|||', $qtyArray));
        $this->db->bind(':price', implode('|||', $priceArray));
        $this->db->bind(':tax', implode('|||', $taxArray));
        $this->db->bind(':total', implode('|||', $totalArray));
        $this->db->bind(':state', implode('|||', $stateArray));
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_sale WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveThemakesalesinvoiceOrderData($saleId,$data)
    {
        // $this->db->query('SELECT * FROM temp_sale');
        // $row = $this->db->resultSet();
       
        // $itemIdArray = array();
        // $itemNameArray = array();
        // $qtyArray = array();
        // $priceArray = array();
        // $taxArray = array();
        // $totalArray = array();
        // $stateArray = array();
        // $a=0;
        // foreach ($row as $key)
        // {
        //     $itemIdArray[] = $key->item_id;
        //     $itemNameArray[] = $key->item_name; 
        //     $qtyArray[] = $key->s_qty;
        //     $priceArray[] = $key->s_price;
        //     $taxArray[] = $key->s_tax;
        //     $totalArray[] = $key->s_total;
        //     $stateArray[] = $key->s_state;
        //     $this->db->query('SELECT * FROM items WHERE id = :id');
        //     $this->db->bind(':id', $key->item_id);
        //     $x = $this->db->single();
        //     $a = $x->committed_stock;
        //     $a = $a + $key->s_qty;
        //     // $this->db->query('UPDATE items SET committed_stock = :sqty WHERE id = :item_id');
        //     // $this->db->bind(':item_id', $key->item_id);
        //     // $this->db->bind(':sqty',  $a);
        //     // $this->db->execute();    
        // }
        $state_tax = array();
        $item_id = explode("|||", $data['item_id']);
        for ($i=0; $i <sizeof($item_id) ; $i++) { 
            $state_tax[]=$data['state_for_tax'];
        }
        $state_tax = implode("|||", $state_tax);
      

        $this->db->query('INSERT INTO sale_order (item_id, sale_id, item_name, item_qty, item_price, item_tax, item_total, item_state) VALUES(:itemId, :saleId, :itemName, :qty, :price, :tax, :total, :state)');
        $this->db->bind(':saleId', $saleId);
        $this->db->bind(':itemId', $data['item_id']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':tax', $data['tax']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':state', $state_tax);
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_sale WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function add_stock_out_order_details($data)
    {
        
        $this->db->query('INSERT INTO stock_out(customer, customer_id, stock_dt, product, qty, type,price,total,sub_total,total_amount,temp_id) VALUES(:customer, :customer_id, :stock_dt,:product,:qty,:rec,:price,:total,:sub_total,:total_amount,:temp_id)');
        // Bind values
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':stock_dt', $data['stock_dt']);
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':rec', $data['rec']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':temp_id', $data['tempId']);
        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM stock_out WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            return $this->db->single();
        } else {
            die('Error');
        }
    }
     public function update_stock_out_order_details($data)
    {
        $this->db->query('UPDATE stock_out SET customer=:customer,customer_id=:customer_id,stock_dt=:stock_dt,temp_id=:temp_id WHERE id=:id');
        // product=:product,qty=:qty,type=:rec,price=:price,total=:total,sub_total=:sub_total,total_amount=:total_amount,
        // Bind values
        $this->db->bind(':id', $data['stockoutid']);
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':stock_dt', $data['stock_dt']);
        // $this->db->bind(':product', $data['product']);
        // $this->db->bind(':qty', $data['qty']);
        // $this->db->bind(':rec', $data['rec']);
        // $this->db->bind(':price', $data['price']);
        // $this->db->bind(':total', $data['total']);
        // $this->db->bind(':sub_total', $data['sub_total']);
        // $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':temp_id', $data['tempId']);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function saveThesales_stock_out($saleId,$data)
    {
        $this->db->query('SELECT * FROM temp_stock_out WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        // arrays
        $itemIdArray = array();
        $itemNameArray = array();
        $qtyArray = array();
        $recArray = array();
        $priceArray = array();
        $rtotalArray = array();
        $a=0;
        foreach ($row as $key)
        {
            $itemIdArray[] = $key->item_id;
            $itemNameArray[] = $key->item_name; 
            $qtyArray[] = $key->s_qty;
            $recArray[] = $key->type;
            $priceArray[] = $key->price;
            $rtotalArray[] = $key->total;
            $this->db->query('SELECT * FROM items WHERE id = :id');
            $this->db->bind(':id', $key->item_id);
            $x = $this->db->single();
            $a = $x->committed_stock;
            $a = $a + $key->s_qty;
            $this->db->query('UPDATE items SET committed_stock = :sqty WHERE id = :item_id');
            $this->db->bind(':item_id', $key->item_id);
            $this->db->bind(':sqty',  $a);
            $this->db->execute();    
        }

        $this->db->query('INSERT INTO stock_out_order (item_id, item_name, item_qty, item_rec,item_price,item_rtotal,item_sub_total,item_grand_total,stock_out_id) VALUES(:itemId, :itemName, :qty, :rec,:price,:rtotal,:sub_total,:total_amount,:temp_id)');
        $this->db->bind(':itemId', implode('|||', $itemIdArray));
        $this->db->bind(':itemName', implode('|||', $itemNameArray));
        $this->db->bind(':qty', implode('|||', $qtyArray));
        $this->db->bind(':rec', implode('|||', $recArray));
        $this->db->bind(':price', implode('|||', $priceArray));
        $this->db->bind(':rtotal', implode('|||', $rtotalArray));
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':temp_id', $saleId);
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_stock_out WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThesales_stock_out($data)
    {
        $saleId = $data['stockoutid'];
        $this->db->query('SELECT * FROM temp_stock_out WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        // arrays
        $itemIdArray = array();
        $itemNameArray = array();
        $qtyArray = array();
        $recArray = array();
        $priceArray = array();
        $rtotalArray = array();
        $a=0;
        foreach ($row as $key)
        {
            $itemIdArray[] = $key->item_id;
            $itemNameArray[] = $key->item_name; 
            $qtyArray[] = $key->s_qty;
            $recArray[] = $key->type;
            $priceArray[] = $key->price;
            $rtotalArray[] = $key->total;
            $this->db->query('SELECT * FROM items WHERE id = :id');
            $this->db->bind(':id', $key->item_id);
            $x = $this->db->single();
            $a = $x->committed_stock;
            $a = $a + $key->s_qty;
            $this->db->query('UPDATE items SET committed_stock = :sqty WHERE id = :item_id');
            $this->db->bind(':item_id', $key->item_id);
            $this->db->bind(':sqty',  $a);
            $this->db->execute();    
        }

        $this->db->query('UPDATE stock_out_order SET item_id=:itemId, item_name=:itemName, item_qty=:qty, item_rec=:rec, item_price=:price, item_rtotal=:rtotal, item_sub_total=:sub_total, item_grand_total=:total_amount, stock_out_id=:temp_id WHERE stock_out_id=:temp_id ');
        $this->db->bind(':itemId', implode('|||', $itemIdArray));
        $this->db->bind(':itemName', implode('|||', $itemNameArray));
        $this->db->bind(':qty', implode('|||', $qtyArray));
        $this->db->bind(':rec', implode('|||', $recArray));
        $this->db->bind(':price', implode('|||', $priceArray));
        $this->db->bind(':rtotal', implode('|||', $rtotalArray));
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':temp_id', $saleId);
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_stock_out WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveThedistributorOrderData($dId)
    {
        $this->db->query('SELECT * FROM temp_distributor WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();

        // arrays

        $itemIdArray = array();
        $itemNameArray = array();
        $qtyArray = array();
        $priceArray = array();
        $taxArray = array();
        $totalArray = array();
        $stateArray = array();
        $a=0;
        foreach ($row as $key)
        {
            $itemIdArray[] = $key->item_id;
            $itemNameArray[] = $key->item_name; 
            $qtyArray[] = $key->s_qty;
            $priceArray[] = $key->s_price;
            $taxArray[] = $key->s_tax;
            $totalArray[] = $key->s_total;
            $stateArray[] = $key->s_state;
            $this->db->query('SELECT * FROM items WHERE id = :id');
            $this->db->bind(':id', $key->item_id);
            $x = $this->db->single();
            $a = $x->committed_stock;
            $a = $a + $key->s_qty;
            $this->db->query('UPDATE items SET committed_stock = :sqty WHERE id = :item_id');
            $this->db->bind(':item_id', $key->item_id);
            $this->db->bind(':sqty',  $a);
            $this->db->execute();    
        }

        $this->db->query('INSERT INTO distributor_order (item_id, distributor_id, item_name, item_qty, item_price, item_tax, item_total, item_state) VALUES(:itemId, :dId, :itemName, :qty, :price, :tax, :total, :state)');
        $this->db->bind(':dId', $dId);
        $this->db->bind(':itemId', implode('|||', $itemIdArray));
        $this->db->bind(':itemName', implode('|||', $itemNameArray));
        $this->db->bind(':qty', implode('|||', $qtyArray));
        $this->db->bind(':price', implode('|||', $priceArray));
        $this->db->bind(':tax', implode('|||', $taxArray));
        $this->db->bind(':total', implode('|||', $totalArray));
        $this->db->bind(':state', implode('|||', $stateArray));
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_distributor WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveThedelivery_challanOrderData($delivery_challan_id)
    {
        $this->db->query('SELECT * FROM temp_delivery_challan WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();

        // arrays

        $itemIdArray = array();
        $itemNameArray = array();
        $qtyArray = array();
        $priceArray = array();
        $taxArray = array();
        $totalArray = array();
        $stateArray = array();

        foreach ($row as $key)
        {
            $itemIdArray[] = $key->item_id;
            $itemNameArray[] = $key->item_name; 
            $qtyArray[] = $key->s_qty;
            $priceArray[] = $key->s_price;
            $taxArray[] = $key->s_tax;
            $totalArray[] = $key->s_total;
            $stateArray[] = $key->s_state;
        }

        $this->db->query('INSERT INTO delivery_challan_order (item_id, delivery_challan_id, item_name, item_qty, item_price, item_tax, item_total, item_state) VALUES(:itemId, :delivery_challan_id, :itemName, :qty, :price, :tax, :total, :state)');
        $this->db->bind(':delivery_challan_id', $delivery_challan_id);
        $this->db->bind(':itemId', implode('|||', $itemIdArray));
        $this->db->bind(':itemName', implode('|||', $itemNameArray));
        $this->db->bind(':qty', implode('|||', $qtyArray));
        $this->db->bind(':price', implode('|||', $priceArray));
        $this->db->bind(':tax', implode('|||', $taxArray));
        $this->db->bind(':total', implode('|||', $totalArray));
        $this->db->bind(':state', implode('|||', $stateArray));
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_delivery_challan WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePackage($data)
    {
        $this->db->query('INSERT INTO sales_pacakge (sales_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:sale_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:qtyPack, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':sale_id', $data['sale_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePackage_stock_out($data)
    {
        $this->db->query('INSERT INTO stock_out_package (stock_out_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:stock_out_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:qtyPack, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':stock_out_id', $data['stock_out_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePackage_for_dist($data)
    {
        $this->db->query('INSERT INTO distributor_pacakge (distributor_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:distributor_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:qtyPack, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':distributor_id', $data['distributor_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePackage_rem_package($data)
    {
        $this->db->query('INSERT INTO sales_pacakge (sales_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:sale_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:total_item_received, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':sale_id', $data['sale_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);
        $this->db->bind(':total_item_received',$data['total_item_received']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function updateThePackage_rem_package_for_stock_out($data)
    {
        $this->db->query('INSERT INTO stock_out_package (stock_out_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:stock_out_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:total_item_received, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':stock_out_id', $data['stock_out_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);
        $this->db->bind(':total_item_received',$data['total_item_received']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePackage_rem_package_for_dist($data)
    {
        $this->db->query('INSERT INTO distributor_pacakge (distributor_id, item_id, item_name, item_ordered, item_packed, item_to_pack,total_item_received, status) VALUES(:distributor_id, :itemId, :itemName, :itemQty, :qtyPack, :qty_need_to_Pack,:total_item_received, 1)');
        $this->db->bind(':itemId', $data['itemId']);
        $this->db->bind(':itemName', $data['itemName']);
        $this->db->bind(':itemQty', $data['itemQty']);
        $this->db->bind(':qtyPack', $data['qtyPack']);
        $this->db->bind(':distributor_id', $data['distributor_id']);
        $this->db->bind(':qty_need_to_Pack',$data['qty_need_to_Pack']);
        $this->db->bind(':total_item_received',$data['total_item_received']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function updateShipmentDb($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $spId)
    {
        $this->db->query('UPDATE sales_pacakge SET ship_date = :shippingDate, ship_carrier = :shipCarrier, tracking = :tracking, shipping_charges = :shippingCharges, notes = :shippingNotes, status = 2 WHERE sp_id = :spId');
        $this->db->bind(':shippingDate', $shippingDate);
        $this->db->bind(':shipCarrier', $shipCarrier);
        $this->db->bind(':tracking', $tracking);
        $this->db->bind(':shippingCharges', $shippingCharges);
        $this->db->bind(':shippingNotes', $shippingNotes);
        $this->db->bind(':spId', $spId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function updateShipmentDb_for_stock_out($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $st_id)
    {
        $this->db->query('UPDATE stock_out_package SET ship_date = :shippingDate, ship_carrier = :shipCarrier, tracking = :tracking, shipping_charges = :shippingCharges, notes = :shippingNotes, status = 2 WHERE st_id = :st_id');
        $this->db->bind(':shippingDate', $shippingDate);
        $this->db->bind(':shipCarrier', $shipCarrier);
        $this->db->bind(':tracking', $tracking);
        $this->db->bind(':shippingCharges', $shippingCharges);
        $this->db->bind(':shippingNotes', $shippingNotes);
        $this->db->bind(':st_id', $st_id);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function updateShipmentDb_for_dist($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $dpId)
    {
        $this->db->query('UPDATE distributor_pacakge SET ship_date = :shippingDate, ship_carrier = :shipCarrier, tracking = :tracking, shipping_charges = :shippingCharges, notes = :shippingNotes, status = 2 WHERE dp_id = :dpId');
        $this->db->bind(':shippingDate', $shippingDate);
        $this->db->bind(':shipCarrier', $shipCarrier);
        $this->db->bind(':tracking', $tracking);
        $this->db->bind(':shippingCharges', $shippingCharges);
        $this->db->bind(':shippingNotes', $shippingNotes);
        $this->db->bind(':dpId', $dpId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function updateTheShipmentToDelivedDb($sId)
    {
        $this->db->query('UPDATE sales_pacakge SET status = 3 WHERE sp_id = :sId');
        $this->db->bind(':sId', $sId);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateTheShipmentToDelivedDb_for_stock_out($sId)
    {
        $this->db->query('UPDATE stock_out_package SET status = 3 WHERE st_id = :sId');
        $this->db->bind(':sId', $sId);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function update_commited_stock($Id,$qty)
    {
        $comm =0;
        $ava = 0;
        $this->db->query('SELECT * FROM items WHERE id = :Id');
        $this->db->bind(':Id', $Id);
        $x = $this->db->single();
        $ava = $x->available_stock;
        $comm = $x->committed_stock;
        $comm = $comm - $qty;
        $ava = $ava - $qty;
        $this->db->query('UPDATE items SET committed_stock=:comm WHERE id = :Id');
        $this->db->bind(':Id', $Id);
        $this->db->bind(':comm', $comm);        
        // $this->db->bind(':ava', $ava);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function update_stock($s,$qty,$item_id)
    {   $created_at=date('Y-m-d h:i:s');
        $q = '-'.$qty;
        $this->db->query('INSERT INTO stock(customer_name,customer_id,sales_order_no,stock_on_hand, remaining_stock, stock_total_receive,total_qty_order,item_id, Expected_date,created_at,purchase_sales) VALUES (:customer_name,:customer_id,:sales_order_no,:stock_on_hand,0,0,:stock_on_hand,:item_id,:created_at,:expected_delivery_date,1)');
        $this->db->bind(':customer_name', $s->customer_name);
        $this->db->bind(':customer_id', $s->customer_id);
        $this->db->bind(':sales_order_no', $s->id);
        $this->db->bind(':stock_on_hand', $q);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':expected_delivery_date', $s->expected_delivery_date);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function update_stock_for_dist($s,$qty,$item_id)
    {   $created_at=date('Y-m-d h:i:s');
        $q = '-'.$qty;
        $this->db->query('INSERT INTO stock(distributor_name,distributor_id,sales_order_no,stock_on_hand, remaining_stock, stock_total_receive,total_qty_order,item_id, Expected_date,created_at,purchase_sales) VALUES (:distributor_name,:distributor_id,:sales_order_no,:stock_on_hand,0,0,:stock_on_hand,:item_id,:created_at,:expected_delivery_date,2)');
        $this->db->bind(':distributor_name', $s->distributor_name);
        $this->db->bind(':distributor_id', $s->distributor_id);
        $this->db->bind(':sales_order_no', $s->id);
        $this->db->bind(':stock_on_hand', $q);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':expected_delivery_date', $s->expected_delivery_date);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTheShipmentToDelivedDb_for_dist($sId)
    {
        $this->db->query('UPDATE distributor_pacakge SET status = 3 WHERE dp_id = :sId');
        $this->db->bind(':sId', $sId);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getTheProcessCreate($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sales_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
    public function getTheProcessCreate_for_stock($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE stock_out_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
    public function getTheProcessCreate_fordist($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE distributor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
     public function getsalesDetails($id)
    {
        $this->db->query('SELECT * FROM sales WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getstockoutDetails($id)
    {
        $this->db->query('SELECT * FROM stock_out WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_details_of_stock($id)
    {
        $this->db->query('SELECT * FROM sales WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_details_of_stock_for_stock_out($id)
    {
        $this->db->query('SELECT * FROM stock_out WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_details_of_stock_for_dist($id)
    {
        $this->db->query('SELECT * FROM sdistributor WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getdistDetails($id)
    {
        $this->db->query('SELECT * FROM sdistributor WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getsalesOrder_forpack($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sales_id = :id ORDER BY sp_id DESC');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getstockout_forpack($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE stock_out_id = :id ORDER BY st_id DESC');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
     public function getdistributor_order_forpack($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE distributor_id = :id ORDER BY dp_id DESC');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
     public function get_sales_from_sales_pacakge($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sp_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x->sales_id;
    }
     public function get_stock_out_from_sales_pacakge($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x->stock_out_id;
    }
    public function get_stock_out_from_stock_out_pacakge($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x->stock_out_id;
    }
    public function get_stock_out_from_stock_out_pacakge_edit($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x->stock_out_id;
    }
    public function get_stock_out_from_stock_out_pacakge_edit_all($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
     public function get_sales_pack_details_for_calculate($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sp_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
    public function get_stock_out_pack_details_for_calculate($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
    public function get_dist_pack_details_for_calculate($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE dp_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
    public function get_Distributor_from_Distributor_pacakge($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE dp_id = :id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x->distributor_id;
    }
    public function getsalesOrder_forpack_all($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sales_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
     public function getstock_out_forpack_all($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE stock_out_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
     public function getstockoutOrder_forpack_all($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE stock_out_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
    public function getdistOrder_forpack_all($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE distributor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
     public function getdistributor_order_forpack_all($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE distributor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
    public function getsalesonlyDetails($id)
    {
        $this->db->query('SELECT * FROM sales WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getsalesOrderDetails($id)
    {
        $this->db->query('SELECT * FROM sale_order WHERE sale_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getstockoutOrderDetails($id)
    {
        $this->db->query('SELECT * FROM stock_out_order WHERE stock_out_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getdistributor_orderDetails($id)
    {
        $this->db->query('SELECT * FROM distributor_order WHERE distributor_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getdelivery_challan_orderDetails($id)
    {
        $this->db->query('SELECT * FROM delivery_challan_order WHERE delivery_challan_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_all_tax($lim, $off)
    {
        $this->db->query('SELECT * FROM tax LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
    public function get_all_tax_from_id($id)
    {
        $this->db->query('SELECT * FROM tax WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updatetax($id,$tax)
    {
        $this->db->query('UPDATE tax SET tax =:tax WHERE id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':tax', $tax);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function updateThePositions($id,$posCode, $posDetails)
    {
        $this->db->query('UPDATE positions SET position_code =:posCode, position_details =:posDetails WHERE position_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':posCode', $posCode);
        $this->db->bind(':posDetails', $posDetails);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function add_company_details($data)
    {
        $this->db->query('INSERT INTO company_details(name, email, street1, street2, city, state, country, zip_code, phone, fax) VALUES (:name, :email, :street1, :street2, :city, :state, :country, :zip_code, :phone, :fax )');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function comp_details()
    {
        $this->db->query('SELECT * FROM company_details');
        return $this->db->single();
    }
    public function updatecompany_details($data)
    {
        $this->db->query('UPDATE company_details SET name=:name, email=:email, street1=:street1, street2=:street2, city=:city, state=:state, country=:country, zip_code=:zip_code, phone=:phone, fax=:fax WHERE id =:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':zip_code', $data['zip_code']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fax', $data['fax']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function get_single_company($id)
    {
        $this->db->query("SELECT * FROM company_details WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function checkForTheSubCategory2($sCName2, $cId2)
    {
        $this->db->query('SELECT sc2_id FROM sub_category2 WHERE sc2_name = :sCName2 AND sub_category_id = :cId2');
        $this->db->bind(':sCName2', $sCName2);
        $this->db->bind(':cId2', $cId2);
        $this->db->single();
        return $this->db->rowCount();
    }
    public function saveSC2($sCName2, $cId2)
    {
        $this->db->query('INSERT INTO sub_category2 (sc2_name, sub_category_id) VALUES(:sCName2, :cId2)');
        $this->db->bind(':sCName2', $sCName2);
        $this->db->bind(':cId2', $cId2);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
     public function saveSC2_for_new_category($sCName2, $cId2,$tid)
    {
        $this->db->query('INSERT INTO category_new (category_name, model_id, type_id) VALUES(:sCName2, :cId2,:tid)');
        $this->db->bind(':sCName2', $sCName2);
        $this->db->bind(':cId2', $cId2);
        $this->db->bind(':tid',$tid);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
     public function saveSC2_for_new_subcategory($sCName2, $cId2,$mid,$tid)
    {
        $this->db->query('INSERT INTO sub_category_new (sc_name, category_id,model_id,type_id) VALUES(:sCName2, :cId2,:mid,:tid)');
        $this->db->bind(':sCName2', $sCName2);
        $this->db->bind(':cId2', $cId2);
         $this->db->bind(':mid',$mid);
          $this->db->bind(':tid',$tid);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function getAllSubCategories2($lim, $off)
    {
        $this->db->query('SELECT * FROM sub_category2 LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
    public function getsubcatName2($cId)
    {
        $this->db->query('SELECT sc2_name FROM sub_category2 WHERE sc2_id = :cId');
        $this->db->bind(':cId', $cId);
        $cn = $this->db->single();
        return $cn->sc2_name;
    }
    public function get_all_subcategory2($id)
    {
        $this->db->query('SELECT * FROM sub_category2 WHERE sc2_id = :sc2_id');
        $this->db->bind(':sc2_id', $id);
        return $this->db->single();
    }
    public function updatesubCategoryDb2($id,$sc2_name)
    {
        $this->db->query('UPDATE sub_category2 SET sc2_name =:sc2_name WHERE sc2_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':sc2_name', $sc2_name);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
   
    public function saveSC3($sCName3, $cId3)
    {
        $this->db->query('INSERT INTO sub_category3 (sc3_name, sub_category2_id) VALUES(:sCName3, :cId3)');
        $this->db->bind(':sCName3', $sCName3);
        $this->db->bind(':cId3', $cId3);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function getAllSubCategories3($lim, $off)
    {
        $this->db->query('SELECT * FROM sub_category3 LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
    public function getsubcatName3($cId2)
    {
        $this->db->query('SELECT sc2_name FROM sub_category2 WHERE sc2_id = :cId2');
        $this->db->bind(':cId2', $cId2);
        $cn = $this->db->single();
        return $cn->sc2_name;
    }
    public function get_all_subcategory3($id)
    {
        $this->db->query('SELECT * FROM sub_category3 WHERE sc3_id = :sc3_id');
        $this->db->bind(':sc3_id', $id);
        return $this->db->single();
    }
    public function checkForTheSubCategory3($sCName3, $cId3)
    {
        $this->db->query('SELECT sc3_id FROM sub_category3 WHERE sc3_name = :sCName3 AND sub_category2_id = :cId3');
        $this->db->bind(':sCName3', $sCName3);
        $this->db->bind(':cId3', $cId3);
        $this->db->single();
        return $this->db->rowCount();
    }
    public function updatesubCategoryDb3($id,$sc3_name)
    {
        $this->db->query('UPDATE sub_category3 SET sc3_name =:sc3_name WHERE sc3_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':sc3_name', $sc3_name);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function search_item($name)
    {
        $this->db->query('SELECT * FROM items WHERE name = :name');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }
    public function sub_category_name($id)
    {
        $this->db->query('SELECT * FROM sub_category WHERE sc_id = :sc_id');
        $this->db->bind(':sc_id', $id);
        $x = $this->db->single();
        return $x->sc_name;
    }
    public function sub_category2_name($id)
    {
        $this->db->query('SELECT * FROM sub_category2 WHERE sc2_id = :sc2_id');
        $this->db->bind(':sc2_id', $id);
        $x = $this->db->single();
        return $x->sc2_name;
    } 

    public function sub_category3_name($id)
    {
        $this->db->query('SELECT * FROM sub_category3 WHERE sc3_id = :sc3_id');
        $this->db->bind(':sc3_id', $id);
        $x = $this->db->single();
        return $x->sc3_name;
    }

    public function checkNameDb($name)
    {
        $this->db->query('SELECT id FROM items WHERE name = :name');
        $this->db->bind(':name', $name);
        $this->db->single();
        return $this->db->rowCount();
    }
    public function get_single_stock($id)
    {
        $this->db->query('SELECT * FROM stock WHERE item_id =:item_id');
        $this->db->bind(':item_id', $id);
        $x = $this->db->resultSet();
        return $x;
    }
    public function get_only_single_stock($id)
    {
        $this->db->query('SELECT * FROM stock WHERE id =:id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
    public function insert_new_stock_scan_items($data,$f,$item_name,$qrcode)
    {
        $this->db->query('INSERT INTO stock_out_scan_items_with_stid(stock_id,stock_out_id, item_name, qrcode, img, name, vendor_name_id, customer_name, customer_id, distributor_name, distributor_id, order_number, sales_order_no, batch, stock_on_hand, remaining_stock, stock_total_receive, total_qty_order, item_id, Expected_date, created_at, user_id, user_name, position, receivable, barcode, purchase_sales, temp_qr_id, stock_id_for_refer) VALUES (:stock_id,:stock_out_id, :item_name, :qrcode, :img, :name, :vendor_name_id, :customer_name, :customer_id, :distributor_name, :distributor_id, :order_number, :sales_order_no, :batch, :stock_on_hand, :remaining_stock, :stock_total_receive, :total_qty_order, :item_id, :Expected_date, :created_at, :user_id, :user_name, :position, :receivable, :barcode, :purchase_sales, :temp_qr_id, :stock_id_for_refer)');
            $this->db->bind(':stock_id', $f->id);
            $this->db->bind('stock_out_id', $data['stock_out_id']);
            $this->db->bind(':item_name', $item_name);
            $this->db->bind(':qrcode', $qrcode);
            $this->db->bind(':img', $f->img);
            $this->db->bind(':name', $f->name);
            $this->db->bind(':vendor_name_id', $f->vendor_name_id);
            $this->db->bind(':customer_name', $data['customer']);
            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':distributor_name', $f->distributor_name);
            $this->db->bind(':distributor_id', $f->distributor_id);
            $this->db->bind(':order_number', $f->order_number);
            $this->db->bind(':sales_order_no', $f->sales_order_no);
            $this->db->bind(':batch', $f->batch);
            $this->db->bind(':stock_on_hand', $f->stock_on_hand);
            $this->db->bind(':remaining_stock', $f->remaining_stock);
            $this->db->bind(':stock_total_receive', $f->stock_total_receive);
            $this->db->bind(':total_qty_order', $f->total_qty_order);
            $this->db->bind(':item_id', $f->item_id);
            $this->db->bind(':Expected_date', $f->Expected_date);
            $this->db->bind(':created_at', $f->created_at);
            $this->db->bind(':user_id', $f->user_id);
            $this->db->bind(':user_name', $f->user_name);
            $this->db->bind(':position', $f->position);
            $this->db->bind(':receivable', $f->receivable);
            $this->db->bind(':barcode', $f->barcode);
            $this->db->bind(':purchase_sales', $f->purchase_sales);
            $this->db->bind(':temp_qr_id', $f->temp_qr_id);
            $this->db->bind(':stock_id_for_refer', $f->stock_id_for_refer);
        if($this->db->execute()) 
        {
            $this->db->query("DELETE FROM stock WHERE id = :id");
            $this->db->bind(':id', $f->id);
            $this->db->execute();
            $this->db->query("DELETE FROM temp_scan WHERE stock_id = :id and created_by=:user_id");
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->bind(':id', $f->id);
            $this->db->execute();
            return true;
        } 
        else 
        {
            die('Error');
        }
    }
    public function before_delete_temp()
    {
        $this->db->query("DELETE FROM temp_scan WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
         return true;
    }
     public function before_delete_temp1()
    {
        $this->db->query("DELETE FROM temp_scan1 WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
         return true;
    }

     public function before_delete_temp2()
    {
        $this->db->query("DELETE FROM temp_scan2 WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
         return true;
    }
     public function before_delete_temp3()
    {
        $this->db->query("DELETE FROM temp_scan3 WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
         return true;
    }
    public function before_delete_temp4()
    {
        $this->db->query("DELETE FROM temp_scan4 WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
         return true;
    }

     public function get_company_details()
    {
        $this->db->query('SELECT * FROM company_details');
        return  $this->db->single();
    }

    // save_to_draft
    public function save_to_draft($sno,$purchase_id,$itemId,$itemName,$receivable,$rQty,$rPerQty,$position,$barcode)
    {
        $this->db->query('INSERT INTO receive_item_draft(p_id, serial_no, itemId, itemName, receivable, rQty, rPerQty, position, barcode) VALUES (:purchase_id,:sno,:itemId,:itemName,:receivable,:rQty,:rPerQty,:position,:barcode)');
        $this->db->bind(':sno', $sno);
        $this->db->bind(':purchase_id', $purchase_id);
        $this->db->bind(':itemId', $itemId);
        $this->db->bind(':itemName', $itemName);
        $this->db->bind(':receivable', $receivable);
        $this->db->bind(':rQty', $rQty);
        $this->db->bind(':rPerQty', $rPerQty);
        $this->db->bind(':position', $position);
        $this->db->bind(':barcode', $barcode);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    // get_received_item_by_purchase_id
     public function get_received_item_by_purchase_id($id,$i)
    {
        $this->db->query('SELECT * FROM receive_item_draft WHERE p_id =:id AND serial_no = :sno');
        $this->db->bind(':id', $id);
        $this->db->bind(':sno', $i);
        $x = $this->db->single();
        return $x;
    }
    public function get_temp_receive_draft_using_purchase_id($id)
    {
        $this->db->query('SELECT * FROM receive_item_draft WHERE p_id =:id');
        $this->db->bind(':id', $id);
        $x = $this->db->resultSet();
        return $x;
    }
     public function get_draft_purchase_count($id)
    {
        $this->db->query('SELECT id FROM receive_item_draft where p_id =:id');
        $this->db->bind(':id', $id);
        $this->db->resultSet();
        return $this->db->rowCount();
    }
     public function count_all_purchase_receive_in_draft($id)
    {
        $this->db->query('SELECT p_id FROM receive_item_draft where p_id =:id');
        $this->db->bind(':id', $id);
        $this->db->resultSet();
        $x = $this->db->rowCount();

        $this->db->query('SELECT * FROM purchase_order where purchase_ref_id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        $z = explode('|||', $y->item_id);
        $a = sizeof($z);
        if($x == $a)
        {
            return 1;
        }
        else
        {
            return  0;
        }
    }
    public function get_last_id_stock()
    {
        $this->db->query('SELECT * FROM stock ORDER BY id DESC');
        $y = $this->db->single();
        return $y;
        
    }
    public function getall_customer_by_tags($tags)
    {
        $this->db->query('SELECT * FROM customer WHERE customer_display_name LIKE concat("%", :tags, "%")');
        $this->db->bind(':tags', $tags);
        return $this->db->resultSet();
    }
    public function getall_distributor_by_tags($tags)
    {
        $this->db->query('SELECT * FROM distributor WHERE distributor_first_name LIKE concat("%", :tags, "%")');
        $this->db->bind(':tags', $tags);
        return $this->db->resultSet();
    }
    public function get_package_details_for_sales_invoice($id)
    {
        $this->db->query('SELECT * FROM sales_pacakge WHERE sp_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_package_details_for_stock_out_invoice($id)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE st_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_package_details_for_dist_invoice($id)
    {
        $this->db->query('SELECT * FROM distributor_pacakge WHERE dp_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_type_name_by_id($id)
    {
        $this->db->query("SELECT * FROM types WHERE type_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_model_by_id_single($id)
    {
        $this->db->query("SELECT * FROM model WHERE model_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_model_name_by_id($id)
    {
        $this->db->query("SELECT * FROM model WHERE model_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_category_name_by_id($id)
    {
        $this->db->query("SELECT * FROM category_new WHERE category_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_subcategory_name_by_id($id)
    {
        $this->db->query("SELECT * FROM sub_category_new WHERE sc_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function to_be_packed()
    {
        $this->db->query("SELECT * FROM sales_pacakge where status = 1");
        // $this->db->bind('',);
        return $this->db->resultSet();
    }
     public function to_be_delivered()
    {
        $this->db->query("SELECT * FROM sales_pacakge where status = 3");
        // $this->db->bind('',);
        return $this->db->resultSet();
    }

    public function to_be_shipped()
    {
        $this->db->query("SELECT * FROM sales_pacakge where status = 2");
        // $this->db->bind('',);
        return $this->db->resultSet();
    }
    public function to_be_invoiced()
    {
        $this->db->query("SELECT * FROM sales_pacakge");
        // $this->db->bind('',);
        return $this->db->resultSet();
    }
    public function get_all_sales_order_for_index()
    {
        $this->db->query("SELECT * FROM sales ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }
    public function get_all_purchase_order_details($id)
    {
        $this->db->query('SELECT * FROM purchase where id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;
    }
     public function get_all_nonpurchase_order_details($id)
    {
        $this->db->query('SELECT * FROM nonpurchase where id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;
    }
    public function get_purchase_order_item_details($id)
    {
        $this->db->query('SELECT * FROM purchase_order where purchase_ref_id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;

    }
    public function get_all_non_purchase()
    {
         $this->db->query("SELECT * FROM nonpurchase ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }
     public function getTheItemName($item_id)
    {
        $this->db->query('SELECT name FROM items WHERE id = :item_id');
        $this->db->bind(':item_id', $item_id);
        $it = $this->db->single();
        return $it->name;
    }
    public function get_selected_nonpurchase_print_qr_all_at_once($temp_qr_id)
    {
        $this->db->query('SELECT * FROM nonpurchase WHERE temp_qr_print_all =:id');
        $this->db->bind(':id', $temp_qr_id);
        $x = $this->db->resultSet();
        return $x;
    }
    public function get_selected_stock($temp_qr_id)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id =:id');
        $this->db->bind(':id', $temp_qr_id);
        $x = $this->db->resultSet();
        return $x;
    }
     public function get_selected_stock1($temp_qr_id)
    {
        $this->db->query('SELECT * FROM stock WHERE id =:id');
        $this->db->bind(':id', $temp_qr_id);
        $x = $this->db->resultSet();
        return $x;
    }
    public function get_color($color_id)
    {
       $this->db->query('SELECT * FROM color WHERE color_id = :color_id');
        $this->db->bind(':color_id', $color_id);
        return $this->db->single();
    }
    public function get_size($size_id)
    {
       $this->db->query('SELECT * FROM size WHERE size_id = :size_id');
        $this->db->bind(':size_id', $size_id);
        return $this->db->single();
    }
    public function get_all_s_stock($lim, $off)
    {
        $this->db->query("SELECT * FROM items ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function getdetails()
    {
        $this->db->query('SELECT * FROM items');
        $row = $this->db->resultSet();
        return $row;
    }
    public function add_barcode_to_db($item_id,$item_name,$l,$type)
    {
        $this->db->query('INSERT INTO temp_scan(item_id,stock_id,item_name,qty,type,barcode,created_by) VALUES(:item_id,:stockid,:item_name,:qty,:type,:barcode,:user_id)');
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':stockid', $l);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':qty', 1);
        $this->db->bind(':type',$type);
        $this->db->bind(':barcode',("EG".$l));
        $this->db->bind(':user_id',$_SESSION['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function add_temp_direct_stock_out($item_id,$item_name,$l,$type)
    {
        $this->db->query('INSERT INTO temp_scan2(item_id,stock_id,item_name,qty,type,barcode,created_by) VALUES(:item_id,:stockid,:item_name,:qty,:type,:barcode,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':stockid', $l);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':qty', 1);
        $this->db->bind(':type',$type);
        $this->db->bind(':barcode',("EG".$l));
        if ($this->db->execute()) 
        {
            return true;
        } else {
            die('Error');
        }
    }
    public function add_temp_direct_stock_out3($item_id,$item_name,$l,$type,$sqty)
    {
        $this->db->query('INSERT INTO temp_scan3(item_id,stock_id,item_name,qty,type,barcode,created_by) VALUES(:item_id,:stockid,:item_name,:qty,:type,:barcode,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':stockid', $l);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':qty', $sqty);
        $this->db->bind(':type',$type);
        $this->db->bind(':barcode',("EG".$l));
        if ($this->db->execute()) 
        {
            return true;
        } else {
            die('Error');
        }
    }
    public function add_barcode_to_db1($item_id,$item_name,$l,$type)
    {
        $this->db->query('INSERT INTO temp_scan1(item_id,stock_id,item_name,qty,type,barcode,created_by) VALUES(:item_id,:stockid,:item_name,:qty,:type,:barcode,:user_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':stockid', $l);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':qty', 1);
        $this->db->bind(':type',$type);
        $this->db->bind(':barcode',("EG".$l));
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function get_all_barcode_to_db()
    {
        $this->db->query('SELECT * FROM temp_scan WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;   
    }
    public function get_stock_from_id($l)
    {
        $this->db->query('SELECT * FROM stock WHERE id = :l');
        $this->db->bind(':l', $l);
        return $this->db->single();
          
    }
     public function get_stock_outofsales_from_id($l)
    {
        $this->db->query('SELECT * FROM stock_out_scan_items_with_stid WHERE stock_id = :l');
        $this->db->bind(':l', $l);
        return $this->db->single();
          
    }
    public function get_stock_outofsales_from_id_for_all($l)
    {
        $this->db->query('SELECT * FROM stock_out_scan_items_with_stid WHERE stock_out_id = :l AND salesordirectpack = 1');
        $this->db->bind(':l', $l);
        return $this->db->resultSet();
          
    }
     public function get_stock_outofsales_from_id_for_all_st($l)
    {
        $this->db->query('SELECT * FROM stock_out_scan_items_with_stid WHERE stock_out_id = :l AND salesordirectpack = 0');
        $this->db->bind(':l', $l);
        return $this->db->resultSet();
          
    }
    public function get_stockoutid_from_id($stockoutid)
    {
        $this->db->query('SELECT * FROM stock_out_order WHERE stock_out_id = :stockoutid');
        $this->db->bind(':stockoutid', $stockoutid);
        return $this->db->single();
          
    }
    public function stock_out_package_qty($stockoutid)
    {
        $this->db->query('SELECT * FROM stock_out_package WHERE stock_out_id = :stockoutid');
        $this->db->bind(':stockoutid', $stockoutid);
        return $this->db->single();
    }
    public function get_salesorder_from_id($sales_order)
    {
        $this->db->query('SELECT * FROM sale_order WHERE sale_id = :sales_order');
        $this->db->bind(':sales_order', $sales_order);
        return $this->db->single();
          
    }
     public function get_all_tempscan_stock_out($lim, $off)
    {
        $this->db->query("SELECT * FROM temp_scan WHERE created_by=:user_id ORDER BY id LIMIT :lim OFFSET :off");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_all_temp_scan()
    {
        $this->db->query('SELECT * FROM temp_scan WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;  
    }
    public function get_all_temp_scan_direct_package()
    {
        $this->db->query('SELECT * FROM temp_scan2 WHERE created_by=:user_id ORDER BY id DESC');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;  
    }
    public function get_all_temp_scan_sales_return()
    {
        $this->db->query('SELECT * FROM temp_scan4 WHERE created_by=:user_id ORDER BY id DESC');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;  
    }
    public function get_all_temp_scan_direct_package3()
    {
        $this->db->query('SELECT * FROM temp_scan3 WHERE created_by=:user_id ORDER BY id DESC');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;  
    }
    public function get_all_temp_scan1()
    {
        $this->db->query('SELECT * FROM temp_scan1 WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $row = $this->db->resultSet();
        return $row;  
    }
    public function get_temp_scan_count_qty($itemid)
    {
        $this->db->query("SELECT qty FROM temp_scan  WHERE item_id=:itemid and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':itemid', $itemid);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_temp_scan2_count_qty1($l)
    {
        $this->db->query("SELECT id FROM temp_scan2 WHERE stock_id=:l and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        // $this->db->bind(':itemid', $itemid);
        $this->db->bind(':l', $l);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_temp_scan4_count_qty4($l)
    {
        $this->db->query("SELECT id FROM temp_scan4 WHERE stock_id=:l and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        // $this->db->bind(':itemid', $itemid);
        $this->db->bind(':l', $l);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_temp_scan4_count_qty4_for_DP($l)
    {
        $this->db->query("SELECT id FROM temp_scan4 WHERE stock_id=:l and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        // $this->db->bind(':itemid', $itemid);
        $this->db->bind(':l', $l);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_temp_scan1_count_qty($itemid)
    {
        $this->db->query("SELECT qty FROM temp_scan1  WHERE item_id=:itemid and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':itemid', $itemid);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
     public function get_total_temp_scan_count()
    {
        $this->db->query("SELECT * FROM temp_scan WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_total_temp_scan_details()
    {
        $this->db->query("SELECT * FROM temp_scan WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
    public function get_total_temp_scan_details2()
    {
        $this->db->query("SELECT * FROM temp_scan2 WHERE created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        return $this->db->resultSet();
    }
     public function get_all_stockfor_tbody($lim, $off)
    {
        $this->db->query("SELECT * FROM stock ORDER BY id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
    public function get_stock_from_id_temp_data($l)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id = :l');
        $this->db->bind(':l', $l);
        return $this->db->single();
          
    }
    public function get_stock_from_id_temp_data_for_checkqr($l)
    {
        $this->db->query('SELECT * FROM stock WHERE id = :l');
        $this->db->bind(':l', $l);
        return $this->db->single();
          
    }
     public function count_of_stock_get_stock_from_id_temp_data($l)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id = :l');
        $this->db->bind(':l', $l);
        return $this->db->resultSet();
          
    }
     public function count_of_unboxpurchase_get_stock_from_id_temp_data($l)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id = :l');
        $this->db->bind(':l', $l);
        return $this->db->resultSet();
          
    }
    public function get_selected_stock_for_pieces($stock_id_for_refer)
    {
        $this->db->query('SELECT * FROM stock WHERE stock_id_for_refer =:id');
        $this->db->bind(':id', $stock_id_for_refer);
        $x = $this->db->resultSet();
        return $x;
    }
     public function get_scanqr_stockout($id)
    {
        $this->db->query('SELECT * FROM stock_out WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
          
    }
     public function get_scanqr_stock_out_order($id)
    {
        $this->db->query('SELECT * FROM stock_out_order WHERE stock_out_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
          
    }
     public function get_cust_bill_for_onclick($id)
    {
        if($_SESSION['ctype']==1)
        {
            $this->db->query('SELECT * FROM customer WHERE id=:id and cp_priority =1');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }else
        {
            $this->db->query('SELECT * FROM customer WHERE id=:id and cp_priority =0');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
    }
     public function get_all_customer_cp_priority($id)
    {
        $this->db->query('SELECT * FROM customer WHERE id=:id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
     public function get_vendor_bill_for_onclick($id)
    {
        $this->db->query('SELECT * FROM vendor WHERE vendor_id=:id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_all_category_wise_details11s($category_id,$subCategory,$subCategory1,$subCategory2,$sort_id)
    {
        if($sort_id==1){
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY created_at DESC");
        }elseif ($sort_id==2) {
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY created_at ASC");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details22s($category_id,$subCategory,$subCategory1,$sort_id)
    {
        if($sort_id==1){
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY created_at DESC");
        }elseif ($sort_id==2) {
              $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY created_at ASC");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details33s($category_id,$subCategory,$sort_id)
    {
        if($sort_id==1){
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY created_at DESC ");
        }elseif ($sort_id==2) {
                $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY created_at ASC ");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details44s($category_id,$sort_id)
    {
        if($sort_id==1){
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY created_at DESC ");
        }elseif ($sort_id==2) {
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY created_at ASC ");
        }
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_color_name_by_id($id)
    {
        $this->db->query("SELECT * FROM color WHERE color_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
     public function get_size_name_by_id($id)
    {
        $this->db->query("SELECT * FROM size WHERE size_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_all_category_wise_details011s($category_id,$subCategory,$subCategory1,$subCategory2,$sort_id)
    {
        if($sort_id==1){
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY created_at DESC");
        }elseif ($sort_id==2) {
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY created_at ASC");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details022s($category_id,$subCategory,$subCategory1,$sort_id)
    {
        if($sort_id==1){
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY created_at DESC");
        }elseif ($sort_id==2) {
              $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY created_at ASC");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details033s($category_id,$subCategory,$sort_id)
    {
        if($sort_id==1){
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY created_at DESC ");
        }elseif ($sort_id==2) {
                $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY created_at ASC ");
        }
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details044s($category_id,$sort_id)
    {
        if($sort_id==1){
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY created_at DESC ");
        }elseif ($sort_id==2) {
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY created_at ASC ");
        }
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details111s($category_id,$subCategory,$subCategory1,$subCategory2)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY committed_stock DESC ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details222s($category_id,$subCategory,$subCategory1)
    {
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY committed_stock DESC ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details333s($category_id,$subCategory)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY committed_stock DESC");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details444s($category_id)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY committed_stock DESC");
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details11()
    {
        $this->db->query("SELECT * FROM items");
        return $results = $this->db->resultSet();
    }
    public  function get_all_category_wise_details0111s($category_id,$subCategory,$subCategory1,$subCategory2){
         $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ORDER BY committed_stock DESC ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details0222s($category_id,$subCategory,$subCategory1)
    {
            $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 ORDER BY committed_stock DESC ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details0333s($category_id,$subCategory)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory ORDER BY committed_stock DESC");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details0444s($category_id){
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id ORDER BY committed_stock DESC");
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details1111s($category_id,$subCategory,$subCategory1,$subCategory2,$to,$from)
    {
 $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 AND DATE(created_at)>=:to AND DATE(created_at)<=:froms ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details2222s($category_id,$subCategory,$subCategory1,$to,$from)
    {
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND  DATE(created_at)>=:to AND DATE(created_at)<=:froms");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details3333s($category_id,$subCategory,$to,$from)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND DATE(created_at)>=:to AND DATE(created_at)<=:froms");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details4444s($category_id,$to,$from)
    {
             $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND DATE(created_at)>=:to AND DATE(created_at)<=:froms");
              $this->db->bind(':category_id', $category_id);
             $this->db->bind(':to', $to);
             $this->db->bind(':froms', $from);
            return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details111($to,$from)
    {
        $this->db->query("SELECT * FROM items WHERE DATE(created_at)>=:to AND DATE(created_at)<=:froms");
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details001s($category_id,$subCategory,$subCategory1,$subCategory2)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1 AND subcategory_new_id=:subCategory2 ");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        $this->db->bind(':subCategory2', $subCategory2);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details002s($category_id,$subCategory,$subCategory1)
    {
        $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory AND  category_new_id=:subCategory1");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':subCategory1', $subCategory1);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details003s($category_id,$subCategory){
         $this->db->query("SELECT * FROM items WHERE type_id=:category_id AND model_id=:subCategory");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details004s($category_id){
         $this->db->query("SELECT * FROM items WHERE type_id=:category_id");
        $this->db->bind(':category_id', $category_id);
        return $results = $this->db->resultSet();
    }
     public function get_auto_batch_count()
     {
        $this->db->query("SELECT * FROM stock ORDER BY id DESC ");
        return $results = $this->db->single();
    }
     public function get_all_vendor()
    {
        $this->db->query("SELECT * FROM vendor");
        return $results = $this->db->resultSet();
    }
    public function get_single_non_purchase($id)
    {
         $this->db->query("SELECT * FROM nonpurchase WHERE non_purchase_id_temp=:id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function add_expense_details($data){
          if(!empty($_FILES['files']['name']))
            {
                $f_name = $_FILES['files']['name'];
                $f_temp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $f_extension=explode('.', $f_name);
                $f_extension=strtolower(end($f_extension));
                $f_newfile=uniqid().'.' .$f_extension;
                $store="uploads/" .$f_newfile;
                move_uploaded_file($f_temp, $store);
                $store ="uploads/";
                $_SESSION['attachment']=$f_newfile;
            }
            else
            {
                $_SESSION['attachment']= "dumitem.png";
            }
             //$dimension = $data['Length']."x".$data['width']."x".$data['height'];
            $this->db->query('INSERT INTO expenses(expensetype,expensedetail,expensedate,document,expensevalue,created_by)VALUES(:expensetype,:expensedetail,:expensedate,:attachment,:expensevalue,:created_by)');
              $this->db->bind(':expensetype', $data['expensetype']);
              $this->db->bind(':expensedetail', $data['expensedetail']);
                $this->db->bind(':expensedate', $data['expensedate']);
              $this->db->bind(':attachment',$_SESSION['attachment']);
               $this->db->bind(':expensevalue', $data['expensevalue']);
               $this->db->bind(':created_by', $_SESSION['user_name']);
                    if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
        }
        public function add_expensetype_details($data){
            $this->db->query('INSERT INTO type(typee)VALUES(:typee)');
              $this->db->bind(':typee', $data['typee']);
                    if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
        }
        public function get_all_expenses()
        {
            $this->db->query("SELECT * FROM expenses");
            return $results = $this->db->resultSet();
        }
        public function get_all_expenses1($start,$end)
        {
            $this->db->query("SELECT * FROM expenses WHERE DATE(created_at)>=:start AND DATE(created_at)<=:end");
            $this->db->bind(':start',$start);
             $this->db->bind(':end',$end);
            return $results = $this->db->resultSet();
        }
        public function getalltypes()
        {
            $this->db->query('SELECT * FROM type');
            return $this->db->resultSet();
        }



        
 // table report start

    public function get_all_models()
    {

        $this->db->query("SELECT * FROM model where type_id = :id");


        $this->db->bind(':id', 4);


        return $results = $this->db->resultSet();

    }

     public function get_modelWise_category_count($id)
    {
        $this->db->query("SELECT * FROM category_new WHERE model_id = :id");


        $this->db->bind(':id', $id);

        $this->db->execute();

        return $results = $this->db->rowCount();
        
    }

    public function get_modelWise_category_data($id)
    {
        $this->db->query("SELECT * FROM category_new WHERE model_id = :id");


        $this->db->bind(':id', $id);


        return $results = $this->db->resultSet();
        
    }


    public function get_total_sizes()
    {
        $this->db->query("SELECT * FROM size");

        

        return $results = $this->db->resultSet();
        
    }

    public function get_total_sizes_count()
    {
        $this->db->query("SELECT * FROM size");        

        $this->db->execute();

        return $results = $this->db->rowCount();
        
        
    }

     public function get_all_colors()
    {
        $this->db->query("SELECT * FROM color");

        

        return $results = $this->db->resultSet();
        
    }

    public function get_fistColVal($data)
    {
        $this->db->query("SELECT * FROM items where type_id = :type_id AND model_id = :model_id AND category_new_id = :category_new_id AND color_id = :color_id AND size_id = :size_id");

        $this->db->bind(':type_id', 4);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_new_id', $data['category_new_id']);
        $this->db->bind(':color_id', $data['color_id']);
        $this->db->bind(':size_id', $data['size_id']);

         // $this->db->execute();

        return $results = $this->db->resultSet();
        
    }

    public function get_model_by_id($model_val)
    {

       $this->db->query("SELECT * FROM model where model_id = :id limit 1");


        $this->db->bind(':id', $model_val);


        return $results = $this->db->resultSet();

    }


    public function get_stock_count_boxes($stock_id)
    {

       $this->db->query("SELECT * FROM stock where item_id = :item_id AND receivable = :receivable");


        $this->db->bind(':item_id', $stock_id);

        $this->db->bind(':receivable', 1);


        $this->db->execute();

        return $results = $this->db->rowCount();
    }

    public function get_stock_count_pieces($stock_id)
    {

       $this->db->query("SELECT * FROM stock where item_id = :item_id AND receivable = :receivable");


        $this->db->bind(':item_id', $stock_id);

        $this->db->bind(':receivable', 3);


        $this->db->execute();

        return $results = $this->db->rowCount();
    }


     public function insert_temp_vals($data)
    {
        $this->db->query('INSERT INTO sales_report_temp(customer_id, item_id, type_id, model_id, category_id, size_id, color_id, item_qty, item_rec) VALUES(:customer_id, :item_id, :type_id, :model_id, :category_id, :size_id, :color_id, :item_qty, :item_rec)');

        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':item_id', $data['item_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_id', $data['category_new_id']);
        $this->db->bind(':size_id', $data['size_id']);
        $this->db->bind(':color_id', $data['color_id']);
        $this->db->bind(':item_qty', $data['item_qty']);
        $this->db->bind(':item_rec', $data['item_rec']);

        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }


    public function get_modal_rowSpan($data)
    {

       $this->db->query("SELECT DISTINCT model_id FROM sales_report_temp where customer_id = :customer_id and type_id = :type_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);


        return $results = $this->db->resultSet();

    }

    public function get_catagory_rowSpan($data)
    {

       $this->db->query("SELECT DISTINCT category_id FROM sales_report_temp where customer_id = :customer_id and type_id = :type_id and model_id = :model_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);


        return $results = $this->db->resultSet();

    }

    public function get_from_sales_temp_boxes($stock_id, $customer_id)
    {

       $this->db->query("SELECT * FROM sales_report_temp where customer_id = :customer_id AND item_id = :item_id AND item_rec = :item_rec");


        $this->db->bind(':item_id', $stock_id);

        $this->db->bind(':customer_id', $customer_id);

        $this->db->bind(':item_rec', 1);

        return $results = $this->db->resultSet();
    }


    public function get_from_sales_temp_peices($stock_id, $customer_id)
    {

       $this->db->query("SELECT * FROM sales_report_temp where customer_id = :customer_id AND item_id = :item_id AND item_rec = :item_rec");


        $this->db->bind(':item_id', $stock_id);

        $this->db->bind(':customer_id', $customer_id);

        $this->db->bind(':item_rec', 3);

        return $results = $this->db->resultSet();
    }



    public function delete_sales_report_temp()
    {
        $this->db->query('DELETE from sales_report_temp');


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_all_customers_temp()
    {

       $this->db->query("SELECT DISTINCT customer_id FROM sales_report_count");


        return $results = $this->db->resultSet();
    }

    public function get_size_rowSpan($data)
    {

       $this->db->query("SELECT DISTINCT size_id FROM sales_report_temp where customer_id = :customer_id and type_id = :type_id and model_id = :model_id and category_id = :category_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':category_id', $data['category_id']);


        return $results = $this->db->resultSet();

    }

    public function insert_rep_count($data)
    {
        $this->db->query('INSERT INTO sales_report_count(customer_id, type_id, model_id, category_id, size_count) VALUES(:customer_id, :type_id, :model_id, :category_id, :size_count)');

        $this->db->bind(':customer_id', $data['customer_id']);       
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':size_count', $data['size_id']);
       

        if ($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function get_total_row_count($customer_id)
    {

       $this->db->query("SELECT * FROM sales_report_count where customer_id = :customer_id");

        $this->db->bind(':customer_id', $customer_id);

        $this->db->execute();

        return $results = $this->db->rowCount();
    }

    public function get_modal_count($data)
    {

       $this->db->query("SELECT * FROM sales_report_count where customer_id = :customer_id AND type_id = :type_id AND model_id = :model_id");

        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);

        $this->db->execute();

        return $results = $this->db->rowCount();
    }

    public function get_category_count($data)
    {

       $this->db->query("SELECT * FROM sales_report_count where customer_id = :customer_id AND type_id = :type_id AND model_id = :model_id AND category_id = :category_id");

        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':category_id', $data['category_id']);

        $this->db->execute();

        return $results = $this->db->rowCount();
    }

    public function get_size_rowSpan_count($data)
    {

       $this->db->query("SELECT DISTINCT size_count FROM sales_report_count where customer_id = :customer_id and type_id = :type_id and model_id = :model_id and category_id = :category_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':category_id', $data['category_id']);


        return $results = $this->db->resultSet();

    }

    public function get_modal_rowSpan_c($data)
    {

       $this->db->query("SELECT DISTINCT model_id FROM sales_report_count where customer_id = :customer_id and type_id = :type_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);


        return $results = $this->db->resultSet();

    }

    public function get_catagory_rowSpan_c($data)
    {

       $this->db->query("SELECT DISTINCT category_id FROM sales_report_count where customer_id = :customer_id and type_id = :type_id and model_id = :model_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);


        return $results = $this->db->resultSet();

    }


    public function get_all_customers_ne()
    {

       $this->db->query("SELECT DISTINCT customer_id FROM sales_report_temp_new");


        return $results = $this->db->resultSet();
    }

    public function get_modal_for_cust($data)
    {

       $this->db->query("SELECT DISTINCT model_id FROM sales_report_temp_new where customer_id = :customer_id and type_id = :type_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);


        return $results = $this->db->resultSet();

    }

    public function get_category_for_mo($data)
    {

       $this->db->query("SELECT DISTINCT category_id FROM sales_report_temp_new where customer_id = :customer_id and type_id = :type_id and model_id = :model_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);


        return $results = $this->db->resultSet();

    }

    public function get_size_count_cat($data)
    {

       $this->db->query("SELECT DISTINCT size_id FROM sales_report_temp_new where customer_id = :customer_id and type_id = :type_id and model_id = :model_id and category_id = :category_id");


        $this->db->bind(':customer_id', $data['customer_id']);

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':category_id', $data['category_id']);


        return $results = $this->db->resultSet();

    }

    public function get_val_all($data)
    {
        $this->db->query("SELECT * FROM sales_report_temp_new where type_id = :type_id AND model_id = :model_id AND category_id = :category_id AND color_id = :color_id AND size_id = :size_id");

        $this->db->bind(':type_id', 4);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':color_id', $data['color_id']);
        $this->db->bind(':size_id', $data['size_id']);

         // $this->db->execute();

        return $results = $this->db->resultSet();
        
    }

    public function get_size_name($size_id)
    {
        $this->db->query("SELECT size_name FROM size  WHERE size_id=:size_id ");

        $this->db->bind(':size_id', $size_id);

        

        $res = $this->db->single();

        return $res->size_name;
        
    }

    public function get_category_name($category_id)
    {
        $this->db->query("SELECT category_name FROM category_new  WHERE category_id=:category_id ");

        $this->db->bind(':category_id', $category_id);

        

        $res = $this->db->single();

        return $res->category_name;
        
    }

    public function get_modal_name($model_id)
    {
        $this->db->query("SELECT model_name FROM model  WHERE model_id=:model_id ");

        $this->db->bind(':model_id', $model_id);

        

        $res = $this->db->single();

        return $res->model_name;
        
    }

    public function get_customer_name($customer_id)
    {
        $this->db->query("SELECT customer_display_name FROM customer  WHERE id=:customer_id ");

        $this->db->bind(':customer_id', $customer_id);       

        $res = $this->db->single();

        return $res->customer_display_name;
        
    }

    public function insert_temp_vals_new($data)
    {
        $this->db->query('INSERT INTO sales_report_temp_new(customer_id, item_id, type_id, model_id, category_id, size_id, color_id, item_qty, item_rec) VALUES(:customer_id, :item_id, :type_id, :model_id, :category_id, :size_id, :color_id, :item_qty, :item_rec)');
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':item_id', $data['item_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_id', $data['category_new_id']);
        $this->db->bind(':size_id', $data['size_id']);
        $this->db->bind(':color_id', $data['color_id']);
        $this->db->bind(':item_qty', $data['item_qty']);
        $this->db->bind(':item_rec', $data['item_rec']);

        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }

    public function delete_sales_report_temp_new()
    {
        $this->db->query('DELETE from sales_report_temp_new');


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_data_exsist()
    {
        $this->db->query('SELECT * from sales_report_temp_new');


         return $this->db->resultSet();
    }

    public function get_stock_by_date($from_date, $to_date)
    {
        $this->db->query("SELECT * FROM stock_out  WHERE stock_dt >= :from_date AND stock_dt <= :to_date");

        $this->db->bind(':from_date', $from_date);

        $this->db->bind(':to_date', $to_date);

        

        $res = $this->db->resultSet();

        return $res;
        
    }
    public function get_direct_pack_by_date($from_date, $to_date)
    {
        $this->db->query("SELECT * FROM direct_package  WHERE date(pack_date) >= :from_date AND date(pack_date) <= :to_date");

        $this->db->bind(':from_date', $from_date);

        $this->db->bind(':to_date', $to_date);

        

        $res = $this->db->resultSet();

        return $res;
        
    }

    public function get_each_box_count($itemid)
    {

        $this->db->query("SELECT * FROM items where id = :item_id AND receive = :receivable");

        $this->db->bind(':item_id', $itemid);

        $this->db->bind(':receivable', 1);


        $res = $this->db->single();

        return $res;
    }

    public function get_category_for_modal($data)
    {

        $this->db->query("SELECT * FROM category_new where model_id = :model_id AND type_id = :type_id");

        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':type_id', $data['type_id']);


        $res = $this->db->resultSet();

        return $res;
    }

    public function get_sizes_for_category($data)
    {

        $this->db->query("SELECT DISTINCT size_id FROM items where type_id = :type_id AND model_id = :model_id AND category_new_id = :category_new_id");      

        $this->db->bind(':type_id', $data['type_id']);

        $this->db->bind(':model_id', $data['model_id']);

        $this->db->bind(':category_new_id', $data['category_id']);


        $res = $this->db->resultSet();

        return $res;
    }

    public function get_details_of_modal($model_id)
    {

        $this->db->query("SELECT * FROM model where model_id = :model_id");

        $this->db->bind(':model_id', $model_id);


        $res = $this->db->single();

        return $res;
    }

    public function all_cust()
    {
        if($_SESSION['ctype']==1)
        {
            $this->db->query("SELECT * FROM customer WHERE cp_priority =1");
            $res = $this->db->resultSet();
            return $res;
        }
        else
        {
            $this->db->query("SELECT * FROM customer WHERE cp_priority =0");
            $res = $this->db->resultSet();
            return $res;
        }
    }

    public function all_mod()
    {

        $this->db->query("SELECT * FROM model where type_id = 4");

        $res = $this->db->resultSet();

        return $res;
    }

     public function get_stock_by_date_cust($from_date, $to_date, $customer_id)
    {
        $this->db->query("SELECT * FROM stock_out  WHERE stock_dt >= :from_date AND stock_dt <= :to_date AND customer_id = :customer_id");

        $this->db->bind(':from_date', $from_date);

        $this->db->bind(':to_date', $to_date);

        $this->db->bind(':customer_id', $customer_id);

        

        $res = $this->db->resultSet();

        return $res;
        
    }
     public function get_direct_package_by_date_cust($from_date, $to_date, $customer_id)
    {
        $this->db->query("SELECT * FROM direct_package  WHERE date(pack_date) >= :from_date AND date(pack_date) <= :to_date AND customer_id = :customer_id");

        $this->db->bind(':from_date', $from_date);

        $this->db->bind(':to_date', $to_date);

        $this->db->bind(':customer_id', $customer_id);

        

        $res = $this->db->resultSet();

        return $res;
        
    }





    // table report end



    public function get_all_nonpurchase_order_details_find_batch($batch)
    {
        $this->db->query('SELECT * FROM nonpurchase where batch =:batch');
        $this->db->bind(':batch', $batch);
        $y = $this->db->resultSet();
        return $y;
    }
    public function clear_temp_stockout_db()
    {
        $this->db->query('DELETE FROM temp_stock_out WHERE created_by=:user_id');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->execute();
        return true;
    }
     public function check_tem_scan_item($stock_id)
    {
        $this->db->query("SELECT * FROM temp_scan  WHERE stock_id=:stock_id and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':stock_id', $stock_id);
        return $this->db->single();
        
    }
    public function check_tem_scan1_item($stock_id)
    {
        $this->db->query("SELECT * FROM temp_scan1  WHERE stock_id=:stock_id and created_by=:user_id");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':stock_id', $stock_id);
        return $this->db->single();
        
    }

     public function get_all_stock_out_details($id)
    {
        $this->db->query('SELECT * FROM stock_out where id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;
    }
    public function get_customer_by_id($id)
    {
        $this->db->query("SELECT * FROM customer where id =:id");
        $this->db->bind(':id',$id);
        return $results = $this->db->single();
    }
     public function get_single_stock_out_order_details($id)
    {
        $this->db->query('SELECT * FROM stock_out_order where stock_out_id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;
    }
    public function get_distinct_stock_out()
    {
        $this->db->query("SELECT DISTINCT customer_id from stock_out");
        return $results = $this->db->resultSet();
    }
     public function get_distinct_direct_package_out()
    {
        $this->db->query("SELECT DISTINCT customer_id from direct_package");
        return $results = $this->db->resultSet();
    }
    public function get_customer_namefordisplay($cid)
    {
        $this->db->query('SELECT * FROM customer where id =:cid');
        $this->db->bind(':cid', $cid);
        $y = $this->db->single();
        return $y;  
    }
    public function get_all_stockout_by_custid($customer_id)
    {
        $this->db->query('SELECT * FROM stock_out where customer_id = :customer_id');
        $this->db->bind(':customer_id',$customer_id);
        return $this->db->resultSet();
    }
    public function get_all_direct_pack_by_custid($customer_id)
    {
        $this->db->query('SELECT * FROM direct_package where customer_id = :customer_id');
        $this->db->bind(':customer_id',$customer_id);
        return $this->db->resultSet();
    }
    public function get_all_stockoutorder_by_id($cid)
    {
         $this->db->query('SELECT * FROM stock_out_order where stock_out_id =:id');
        $this->db->bind(':id', $cid);
        $y = $this->db->single();
        return $y; 
    }
     public function get_item_by_id($cid)
    {
         $this->db->query('SELECT * FROM items where id =:id');
        $this->db->bind(':id', $cid);
        $y = $this->db->single();
        return $y; 
    }
    public function get_item_by_id_by_name($cid)
    {
         $this->db->query('SELECT * FROM items where id =:id');
        $this->db->bind(':id', $cid);
        return $this->db->single();
         
    }
     public function stock_outorder_details($id)
    {
        $this->db->query('SELECT * FROM stock_out_order where stock_out_id = :stock_out_id');
        $this->db->bind(':stock_out_id',$id);
        return $this->db->single();
    }
     public function stock_out_details_forcust($id)
    {
        $this->db->query('SELECT * FROM stock_out where id = :stock_out_id');
        $this->db->bind(':stock_out_id',$id);
        return $this->db->single();
    }
    public function get_tax_from_view($item_id)
    {
        $this->db->query('SELECT * FROM items where id = :item_id');
        $this->db->bind(':item_id',$item_id);
        return $this->db->single();
    }
    public function get_single_vendor($id)
    {
        $this->db->query("SELECT * FROM vendor WHERE vendor_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function updatevendordetails($data){
         $this->db->query('UPDATE vendor SET primarySalutation=:primarySalutation,firstName=:firstName,lastName=:lastName,compName=:compName,dispName=:dispName,venEmail=:venEmail,vendPhoneHome=:vendPhoneHome,vendPhoneWork=:vendPhoneWork,vendWeb=:vendWeb,vendCurrency= :vendCurrency,vendPayment=:vendPayment,facebook=:facebook,twittetr= :twittetr,attension=:attension,country=:country,street1=:street1,street2=:street2,city=:city,state=:state,zipcode=:zipcode,phoneAdd=:phoneAdd,fax=:fax,contSalu=:contSalu,contFirstname=:contFirstname,contLastName=:contLastName,contEmail=:contEmail,contWorkPhone=:contWorkPhone,contWorkMobile=:contWorkMobile,gst=:gst,aadhar= :aadhar,passport=:passport,dob=:dob,aniversary=:aniversary,blood=:blood, mfg_sort=:mfg_sort WHERE vendor_id = :id');
        $this->db->bind(':id', $data['id']);
         $this->db->bind(':primarySalutation', $data['primarySalutation']);
        $this->db->bind(':firstName', $data['firstName']);
        $this->db->bind(':lastName', $data['lastName']);
        $this->db->bind(':compName', $data['compName']);
        $this->db->bind(':dispName', $data['dispName']);
        $this->db->bind(':venEmail', $data['venEmail']);
        $this->db->bind(':vendPhoneHome', $data['vendPhoneHome']);
        $this->db->bind(':vendPhoneWork', $data['vendPhoneWork']);
        $this->db->bind(':vendWeb', $data['vendWeb']);
        $this->db->bind(':vendCurrency', $data['vendCurrency']);
        $this->db->bind(':vendPayment', $data['vendPayment']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':twittetr', $data['twittetr']);
        $this->db->bind(':attension', $data['attension']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':street1', $data['street1']);
        $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':zipcode', $data['zipcode']);
        $this->db->bind(':phoneAdd', $data['phoneAdd']);
        $this->db->bind(':fax', $data['fax']);
        $this->db->bind(':contSalu', $data['contSalu']);
        $this->db->bind(':contFirstname', $data['contFirstname']);
        $this->db->bind(':contLastName', $data['contLastName']);
        $this->db->bind(':contEmail', $data['contEmail']);
        $this->db->bind(':contWorkPhone', $data['contWorkPhone']);
        $this->db->bind(':contWorkMobile', $data['contWorkMobile']);
        $this->db->bind(':gst', $data['gst']);
        $this->db->bind(':aadhar', $data['aadhar']);
        $this->db->bind(':passport', $data['passport']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':aniversary', $data['aniversary']);
        $this->db->bind(':blood', $data['blood']);
        $this->db->bind(':mfg_sort', $data['mfg_sort']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_all_category_wise_details789($to,$from)
    {
        $this->db->query("SELECT * FROM nonpurchase WHERE DATE(receive_date)>=:to AND DATE(receive_date)<=:froms");
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_all_category_wise_details00000($to,$from)
    {
        $this->db->query("SELECT * FROM purchase WHERE DATE(ndate)>=:to AND DATE(ndate)<=:froms");
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    public function get_type_name_by_id1($id)
    {
        $this->db->query("SELECT * FROM purchase_order WHERE purchase_ref_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function get_all_category_wise_details11111($category_id,$subCategory,$to,$from)
    {
        $itemsIds = array();
        // $this->db->query("SELECT * FROM nonpurchase WHERE DATE(receive_date)>=:to AND DATE(receive_date)<=:froms");
 //         $this->db->query("SELECT *
 //    FROM items
 // INNER JOIN nonpurchase
 //     ON items.id=nonpurchase.item_id WHERE items.type_id=:category_id AND items.model_id=:subCategory AND DATE(nonpurchase.receive_date)>=:to AND DATE(nonpurchase.receive_date)<=:froms");
        $this->db->query('SELECT items.id, nonpurchase.vendor,nonpurchase.id as ppid, nonpurchase.qty_receive, items.name, nonpurchase.receive_date FROM items INNER JOIN nonpurchase ON items.id = nonpurchase.item_id WHERE items.type_id = :category_id AND items.model_id = :subCategory AND DATE(nonpurchase.receive_date)>=:to AND DATE(nonpurchase.receive_date)<=:froms ');
      $this->db->bind(':category_id', $category_id);
        $this->db->bind(':subCategory', $subCategory);
        $this->db->bind(':to', $to);
        $this->db->bind(':froms', $from);
        return $results = $this->db->resultSet();
    }
    
    public function getallstockoutdetails(){
        $this->db->query("SELECT * FROM stock_out");
           return $results = $this->db->resultSet();
    }
    public function getalldirect_packagedetails(){
        $this->db->query("SELECT * FROM direct_package");
           return $results = $this->db->resultSet();
    }
    public function getallstockoutorder($id){
           $this->db->query("SELECT * FROM stock_out_order WHERE stock_out_id=:id");
              $this->db->bind(':id', $id);
             return $this->db->single();
    }
    public function getallitemdetails($itemid)
    {
        $this->db->query("SELECT *  FROM items WHERE id=:itemid");
        $this->db->bind(':itemid', $itemid);
     return $this->db->single();
    }
    public function getallmodeldetails(){
    $this->db->query("SELECT DISTINCT model_name FROM model");
    return $results = $this->db->resultSet();
    }
    public function get_single_model($modelname)
    {
        $this->db->query("SELECT *  FROM model WHERE model_name=:modelname");
        $this->db->bind(':modelname', $modelname);
        return $this->db->single();
    }
    public function get_transation_details($id)
    {
        $this->db->query("SELECT *  FROM transport_details WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    ///////////////////////////// PAGE MODEL - SHREYA////////////////////////
    public function add_transport_details($data) {
        $this->db->query('INSERT INTO transport_details(lr_number, name, details, created_by) VALUES (:lr_number, :name, :details, :created_by)');
        $this->db->bind(':lr_number', $data['lr_number']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':details', $data['details']);
        $this->db->bind(':created_by', $_SESSION['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            die('Error');
        }
    }
    public function get_all_transportdetails() {
        $this->db->query("SELECT * FROM transport_details");
        return $results = $this->db->resultSet();
    }
    public function get_single_transport($id) {
        $this->db->query("SELECT * FROM transport_details WHERE id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function updatetransport_details($data) {
        $this->db->query('UPDATE transport_details SET lr_number=:lr_number, name=:name, details=:details, created_by=:created_by WHERE id =:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':lr_number', $data['lr_number']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':details', $data['details']);
        $this->db->bind(':created_by', $data['created_by']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function deletetransport_details($id) {
        $this->db->query('DELETE FROM transport_details WHERE id =:id');
        $this->db->bind(':id', $id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function getAllTransportDetails() {
        $this->db->query('SELECT * FROM transport_details');
        return $this->db->resultSet();
    }
    //////end/////
    public function getallstockoutdetails1(){
        $this->db->query("SELECT * FROM stock_out");
           return $results = $this->db->resultSet();
    }
    public function getallstockoutorder1($id){
           $this->db->query("SELECT * FROM stock_out_order WHERE stock_out_id=:id");
              $this->db->bind(':id', $id);
             return $this->db->single();
    }
    public function getallstockpackage($id){
           $this->db->query("SELECT * FROM stock_out_package WHERE stock_out_id=:id ORDER BY st_id DESC");
              $this->db->bind(':id', $id);
             return $this->db->single();
    }
    public function getallitemdetails1($itemid)
      {
            $this->db->query("SELECT *  FROM items WHERE id=:itemid");
            $this->db->bind(':itemid', $itemid);
         return $this->db->single();
      }
    public function getallmodeldetails1()
    {
    $this->db->query("SELECT DISTINCT model_name FROM model");
    return $results = $this->db->resultSet();
    }
    public function get_single_model1($modelname){
               $this->db->query("SELECT *  FROM model WHERE model_name=:modelname");
                $this->db->bind(':modelname', $modelname);
             return $this->db->single();
          }
    // preetham 
    public function getThePreviousPurchaseOrderById($pid)
    {
        $this->db->query('SELECT * FROM purchase_order WHERE purchase_ref_id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function getThePreviousPurchaseById($pid)
    {
        $this->db->query('SELECT * FROM purchase WHERE id = :pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function insertIntoTempData($poBasicDetails)
    {
        $poIds = explode('|||', $poBasicDetails->item_id);
        $poName = explode('|||', $poBasicDetails->item_name);
        $poReceivable = explode('|||', $poBasicDetails->receivable);
        $poUnitQuantity = explode('|||', $poBasicDetails->per_unit_quantity);
        $poActQty = explode('|||', $poBasicDetails->act_qty);
        $poTotal = explode('|||', $poBasicDetails->total_qty);
        $poRowPrice = explode('|||', $poBasicDetails->row_price);
        $poRowTotal = explode('|||', $poBasicDetails->row_total);
        for ($i=0; $i < sizeof($poIds); $i++) 
        { 
            $this->db->query('INSERT INTO temp_data (ItemID, item, receivable, per_unit_qty, act_qty, total_qty , row_price, row_total, created_by) VALUES(:poIds, :poName, :poReceivable, :poUnitQuantity, :poActQty, :poTotal, :poRowPrice, :poRowTotal,:user_id)');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->bind(':poIds', $poIds[$i]);
            $this->db->bind(':poName', $poName[$i]);
            $this->db->bind(':poReceivable', $poReceivable[$i]);
            $this->db->bind(':poUnitQuantity', $poUnitQuantity[$i]);
            $this->db->bind(':poActQty', $poActQty[$i]);
            $this->db->bind(':poTotal', $poTotal[$i]);
            $this->db->bind(':poRowPrice', $poRowPrice[$i]);
            $this->db->bind(':poRowTotal', $poRowTotal[$i]);
            $this->db->execute();
        }
        return true;
    }
     public function getPurchaseDetails($pid) {
        $this->db->query('SELECT * FROM purchase WHERE id=:pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function getPurchaseOrderDetails($pid) {
        $this->db->query('SELECT * FROM purchase_order WHERE purchase_ref_id=:pid');
        $this->db->bind(':pid', $pid);
        return $this->db->single();
    }
    public function get_single_non_purchasefor_del($id)
    {
        $this->db->query('SELECT * FROM nonpurchase WHERE id=:id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function get_count_stock_all_temp_qr_id_based($id)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id=:temp_qr_id');
        $this->db->bind(':temp_qr_id', $id);
        $this->db->resultSet();
        return $this->db->rowCount();
    }   
    public function del_nonpurchase($id)
    {
       // temp_qr_id
        $this->db->query("DELETE FROM nonpurchase WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function del_stock_based_on_temp_qr($id)
    {
       // temp_qr_id
        $this->db->query("DELETE FROM stock WHERE temp_qr_id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
     public function get_count_stock_all_temp_qr_id_based_stock_on_hand($id)
    {
        $this->db->query('SELECT * FROM stock WHERE temp_qr_id=:temp_qr_id');
        $this->db->bind(':temp_qr_id', $id);
        return $this->db->resultSet();
        
    } 
    public function check_pass($opass)
    {
        $this->db->query('SELECT * from employee_new where emp_id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $results = $this->db->single();
        if(password_verify($opass, $results->password))
        {
        return true;
        }
        else
        {
        return false;
        }
    }
    public function update_password($npass)
    {
        $npass = password_hash($npass, PASSWORD_DEFAULT);
        $this->db->query('UPDATE employee_new set password = :npass WHERE emp_id = :id');
        // Bind values
        $this->db->bind(':npass', $npass);
        $this->db->bind(':id', $_SESSION['user_id']);
        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }
    public function clear_temp_non_purchase()
    {
        $this->db->query("DELETE FROM temp_non_purchase");
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function get_all_receive_item_details($id)
    {
        $this->db->query("SELECT * FROM receive_item WHERE purchase_order_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }
    public function delete_single_purchase_details($id)
    {
        $this->db->query("DELETE FROM purchase_order WHERE purchase_ref_id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) 
        {
            $this->db->query("DELETE FROM purchase WHERE id = :id");
            $this->db->bind(':id', $id);
            if ($this->db->execute()) 
            {
                return true;

            }else
            {
                return false;    
            }
        } else {
            return false;
        }
    }
     public function get_selective_types()
    {
        $this->db->query("SELECT * FROM types where type_id = 2 OR type_id = 3 OR type_id = 8 OR type_id = 13 OR type_id = 15 OR type_id = 16");
        $res = $this->db->resultSet();
        return $res;
    }
    public function get_model_For_type($data)
    {
        $this->db->query("SELECT * FROM model WHERE type_id = :type_id");
        $this->db->bind(':type_id', $data['type_id']);
        $res = $this->db->resultSet();
        return $res;
    }
    public function get_fistColVal_switches($data)
    {
        $this->db->query("SELECT * FROM items where type_id = :type_id AND model_id = :model_id AND category_new_id = :category_new_id AND color_id = :color_id");
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':model_id', $data['model_id']);
        $this->db->bind(':category_new_id', $data['category_new_id']);
        $this->db->bind(':color_id', $data['color_id']);
         // $this->db->execute();
        return $results = $this->db->resultSet();
    }
    public function deleteinvoice_db($id)
    {
        $this->db->query("DELETE FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

//********************************salary report part start**********************************
    public function getallsalary_report()
    {
        $this->db->query('SELECT * FROM salaries_new');
        return $this->db->resultSet();
    }  
    public function get_emp_name($id)
    {
        $this->db->query('SELECT * FROM employee_new WHERE device_emp_id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        if(empty($row->emp_name))
        {
            $d = "";
            return $d;
        }else
        {
            return $row->emp_name;
        }
    }
    public function get_emp_name_for_loan($id)
    {
        $this->db->query('SELECT * FROM employee_new WHERE emp_id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        if(empty($row->emp_name))
        {
            $d = "";
            return $d;
        }else
        {
            return $row->emp_name;
        }
    }
     public function get_permissions_name($id)
    {
        $this->db->query('SELECT * FROM permissions WHERE id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        if(!empty($row))
        {
            return $row->permission;
        }else
        {
            return false;
        }
    }
    public function get_single_emp($id)
    {
        $this->db->query('SELECT * FROM employee_new WHERE emp_id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }
    public function getallloan_report()
    {
        $this->db->query('SELECT * FROM loans');
        return $this->db->resultSet(); 
    }
    public function get_all_emp()
    {
        $this->db->query('SELECT * FROM employee_new');
        return $this->db->resultSet(); 
    }
     public function get_permission_all()
    {
        $this->db->query('SELECT * FROM permissions');
        return $this->db->resultSet(); 
    }
    public function update_permissiondb($ps,$id)
    {
        $this->db->query('UPDATE employee_new SET permissions=:permissions WHERE emp_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':permissions', $ps);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    
    public function update_punch_in_details($location)
    {
        $this->db->query('UPDATE employee_new SET punch_in=:punch_in, punch_status=1, location=:location WHERE emp_id =:id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':location', $location);
        $this->db->bind(':punch_in', date('Y-m-d H:i:s'));
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function update_punch_out_details($location)
    {
        $this->db->query('UPDATE employee_new SET punch_out=:punch_out, punch_status="", location=:location WHERE emp_id =:id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':location', $location);
        $this->db->bind(':punch_out', date('Y-m-d H:i:s'));
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function get_single_emp_for_attendence()
    {
        $this->db->query('SELECT * FROM employee_new WHERE emp_id=:id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $row = $this->db->single();
        return $row;
    }

      
//*******************************salary report part end***********************************
//******************************vhr start*********************************************************
    
//******************************vhr end********************************************************
    public function get_item_count_for_dp($itemid,$type)
    {
        $this->db->query("SELECT id FROM temp_scan2 WHERE item_id=:itemid and type=:type and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':itemid', $itemid);
         $this->db->bind(':type', $type);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
    public function get_item_for_dp3($itemid,$type)
    {
        $this->db->query("SELECT * FROM temp_scan3 WHERE item_id=:itemid and type=:type and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':itemid', $itemid);
         $this->db->bind(':type', $type);
        return $this->db->resultSet();
    }
    public function get_item_for_dp($itemid,$type)
    {
        $this->db->query("SELECT * FROM temp_scan2 WHERE item_id=:itemid and type=:type and created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':itemid', $itemid);
         $this->db->bind(':type', $type);
        return $this->db->resultSet();
    }
    
     public function delete_item_for_dp($id)
    {
        $this->db->query("DELETE FROM temp_scan2 WHERE id = :id and created_by=:user_id");
         $this->db->bind(':user_id',$_SESSION['user_id']);
        // $this->db->bind(':itemid', $itemid);
         // $this->db->bind(':type', $type);
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
     public function delete_item_for_dp3($itemid,$type)
    {
        $this->db->query("DELETE FROM temp_scan3 WHERE item_id=:itemid and type=:type and created_by=:user_id");
         $this->db->bind(':user_id',$_SESSION['user_id']);
         $this->db->bind(':itemid', $itemid);
         $this->db->bind(':type', $type);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
     public function get_item_count_for_dp_loop()
    {
        $this->db->query("SELECT id FROM temp_scan2 WHERE  created_by=:user_id ");
        $this->db->bind(':user_id',$_SESSION['user_id']);
        // $this->db->bind(':itemid', $itemid);
         // $this->db->bind(':type', $type);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function save_directpackage($data)
    {
        $tempId = md5(uniqid());
        $this->db->query('INSERT INTO direct_package (customer_id, customer,  item_id, item_name, item_qty, item_rec, created_by, tempId) VALUES(:customer_id,:customer,:item_id, :item_name, :item_qty, :item_rec, :user_id, :tempId)');
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':customer', $data['customer']);
        $this->db->bind(':item_id', $data['item_id']);
        $this->db->bind(':item_name', $data['item_name']);
        $this->db->bind(':item_qty', $data['item_qty']);
        $this->db->bind(':item_rec', $data['item_rec']);
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':tempId',$tempId);
        if($this->db->execute())
        {
            $this->db->query('DELETE FROM temp_scan3 WHERE created_by=:user_id');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->execute();
            $this->db->query("SELECT p_id FROM direct_package WHERE  created_by=:user_id and tempId =:tempId ");
            $this->db->bind(':tempId',$tempId);
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $x = $this->db->single();
            return $x->p_id;
        }
        else
        {
            die('Error');
        }
    }
    public function insert_new_stock_scan_items2($data,$packid,$f,$item_name,$qrcode)
    {
        $this->db->query('INSERT INTO stock_out_scan_items_with_stid(stock_id,stock_out_id, salesordirectpack, item_name, qrcode, img, name, vendor_name_id, customer_name, customer_id, distributor_name, distributor_id, order_number, sales_order_no, batch, stock_on_hand, remaining_stock, stock_total_receive, total_qty_order, item_id, Expected_date, created_at, user_id, user_name, position, receivable, barcode, purchase_sales, temp_qr_id,stock_id_for_refer) VALUES (:stock_id,:packid,1, :item_name, :qrcode, :img, :name, :vendor_name_id, :customer_name, :customer_id, :distributor_name, :distributor_id, :order_number, :sales_order_no, :batch, :stock_on_hand, :remaining_stock, :stock_total_receive, :total_qty_order, :item_id, :Expected_date, :created_at, :user_id, :user_name, :position, :receivable, :barcode, :purchase_sales, :temp_qr_id,:stock_id_for_refer)');
            $this->db->bind(':stock_id', $f->id);
            $this->db->bind('packid', $packid);
            $this->db->bind(':item_name', $item_name);
            $this->db->bind(':qrcode', $qrcode);
            $this->db->bind(':img', $f->img);
            $this->db->bind(':name', $f->name);
            $this->db->bind(':vendor_name_id', $f->vendor_name_id);
            $this->db->bind(':customer_name', $data['customer']);
            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':distributor_name', $f->distributor_name);
            $this->db->bind(':distributor_id', $f->distributor_id);
            $this->db->bind(':order_number', $f->order_number);
            $this->db->bind(':sales_order_no', $f->sales_order_no);
            $this->db->bind(':batch', $f->batch);
            $this->db->bind(':stock_on_hand', $f->stock_on_hand);
            $this->db->bind(':remaining_stock', $f->remaining_stock);
            $this->db->bind(':stock_total_receive', $f->stock_total_receive);
            $this->db->bind(':total_qty_order', $f->total_qty_order);
            $this->db->bind(':item_id', $f->item_id);
            $this->db->bind(':Expected_date', $f->Expected_date);
            $this->db->bind(':created_at', $f->created_at);
            $this->db->bind(':user_id', $f->user_id);
            $this->db->bind(':user_name', $f->user_name);
            $this->db->bind(':position', $f->position);
            $this->db->bind(':receivable', $f->receivable);
            $this->db->bind(':barcode', $f->barcode);
            $this->db->bind(':purchase_sales', $f->purchase_sales);
            $this->db->bind(':temp_qr_id', $f->temp_qr_id);
            $this->db->bind(':stock_id_for_refer', $f->stock_id_for_refer);
        if($this->db->execute()) 
        {
            $this->db->query("DELETE FROM stock WHERE id = :id");
            $this->db->bind(':id', $f->id);
            $this->db->execute();
            $this->db->query("DELETE FROM temp_scan2 WHERE stock_id = :id and created_by=:user_id");
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->bind(':id', $f->id);
            $this->db->execute();
            return true;
        } 
        else 
        {
            die('Error');
        }
    }
     public function get_all_direct_pack_details($lim, $off)
    {
        $this->db->query("SELECT * FROM direct_package ORDER BY p_id DESC LIMIT :lim OFFSET :off");
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $results = $this->db->resultSet();
    }
     public function get_all_directpack_details($id)
    {
        $this->db->query('SELECT * FROM direct_package where p_id =:id');
        $this->db->bind(':id', $id);
        $y = $this->db->single();
        return $y;
    }
    public function add_temp_return_stock_out($k,$item_id,$item_name,$l,$type)
    {
        $this->db->query('INSERT INTO temp_scan4(item_id,stock_id,customer_name,customer_id,item_name,qty,type,barcode,created_by,stock_out_id,salesordirectpack,dateofsale,stock_out_scan_items_id) VALUES(:item_id,:stockid,:customer_name,:customer_id,:item_name,:qty,:type,:barcode,:user_id,:stock_out_id,:salesordirectpack,:dateofsale,:stock_out_scan_items_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':stockid', $l);
        $this->db->bind(':item_name', $item_name);
        $this->db->bind(':qty', 1);
        $this->db->bind(':type',$type);
        $this->db->bind(':barcode',("EG".$l));
        $this->db->bind(':customer_name', $k->customer_name);
        $this->db->bind(':customer_id', $k->customer_id);
        $this->db->bind(':stock_out_id', $k->stock_out_id);
        $this->db->bind(':salesordirectpack', $k->salesordirectpack);
        $this->db->bind(':dateofsale', $k->dateofsale);
        $this->db->bind(':stock_out_scan_items_id',$k->id);
        if ($this->db->execute()) 
        {
            return true;
        } else {
            die('Error');
        }
    }
    public function add_temp_return_stock_out_DP($k)
    {
        $this->db->query('INSERT INTO temp_scan4(item_id,stock_id,customer_name,customer_id,item_name,qty,type,barcode,created_by,stock_out_id,salesordirectpack,dateofsale,stock_out_scan_items_id) VALUES(:item_id,:stockid,:customer_name,:customer_id,:item_name,:qty,:type,:barcode,:user_id,:stock_out_id,:salesordirectpack,:dateofsale,:stock_out_scan_items_id)');
        $this->db->bind(':user_id',$_SESSION['user_id']);
        $this->db->bind(':item_id', $k->item_id);
        $this->db->bind(':stockid', $k->stock_id);
        $this->db->bind(':item_name', $k->item_name);
        $this->db->bind(':qty', 1);
        $this->db->bind(':type',$k->receivable);
        $this->db->bind(':barcode',("EG".$k->stock_id));
        $this->db->bind(':customer_name', $k->customer_name);
        $this->db->bind(':customer_id', $k->customer_id);
        $this->db->bind(':stock_out_id', $k->stock_out_id);
        $this->db->bind(':salesordirectpack', $k->salesordirectpack);
        $this->db->bind(':dateofsale', $k->dateofsale);
        $this->db->bind(':stock_out_scan_items_id',$k->id);
        if ($this->db->execute()) 
        {
            return true;
        } else {
            die('Error');
        }
    }
    public function get_all_stock_out_scan_items_with_stid()
    {
        $this->db->query('SELECT * FROM stock_out_scan_items_with_stid');
        return $this->db->resultSet(); 
    }
    public function stock_out_scan_items_with_stid($id)
    {
        $this->db->query('SELECT * FROM stock_out_scan_items_with_stid where id =:id');
        $this->db->bind(':id', $id);
        $f = $this->db->single();

        $this->db->query('INSERT INTO stock(id,name, vendor_name_id, customer_name, customer_id, distributor_name, distributor_id, order_number, sales_order_no, batch, stock_on_hand, remaining_stock, stock_total_receive, total_qty_order, item_id, Expected_date, created_at, user_id, user_name, position, receivable, barcode, purchase_sales, temp_qr_id,stock_id_for_refer) VALUES (:stock_id, :name, :vendor_name_id, :customer_name, :customer_id, :distributor_name, :distributor_id, :order_number, :sales_order_no, :batch, :stock_on_hand, :remaining_stock, :stock_total_receive, :total_qty_order, :item_id, :Expected_date, :created_at, :user_id, :user_name, :position, :receivable, :barcode, :purchase_sales, :temp_qr_id,:stock_id_for_refer)');
            $this->db->bind(':stock_id', $f->stock_id);
            $this->db->bind(':name', $f->name);
            $this->db->bind(':vendor_name_id', $f->vendor_name_id);
            $this->db->bind(':customer_name', "null");
            $this->db->bind(':customer_id', "null");
            $this->db->bind(':distributor_name', $f->distributor_name);
            $this->db->bind(':distributor_id', $f->distributor_id);
            $this->db->bind(':order_number', $f->order_number);
            $this->db->bind(':sales_order_no', $f->sales_order_no);
            $this->db->bind(':batch', $f->batch);
            $this->db->bind(':stock_on_hand', $f->stock_on_hand);
            $this->db->bind(':remaining_stock', $f->remaining_stock);
            $this->db->bind(':stock_total_receive', $f->stock_total_receive);
            $this->db->bind(':total_qty_order', $f->total_qty_order);
            $this->db->bind(':item_id', $f->item_id);
            $this->db->bind(':Expected_date', $f->Expected_date);
            $this->db->bind(':created_at', $f->created_at);
            $this->db->bind(':user_id', $f->user_id);
            $this->db->bind(':user_name', $f->user_name);
            $this->db->bind(':position', $f->position);
            $this->db->bind(':receivable', $f->receivable);
            $this->db->bind(':barcode', $f->barcode);
            $this->db->bind(':purchase_sales', $f->purchase_sales);
            $this->db->bind(':temp_qr_id', $f->temp_qr_id);
            $this->db->bind(':stock_id_for_refer', $f->temp_qr_id);
        if($this->db->execute()) 
        {
            $this->db->query("DELETE FROM stock_out_scan_items_with_stid WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();
            return true;
        } 
        else 
        {
            die('Error');
        }

    }
     public function get_single_stock_out($id)
    {
        $this->db->query('SELECT * FROM stock_out WHERE id =:id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
 public function get_single_stock_out_order($id)
    {
        $this->db->query('SELECT * FROM stock_out_order WHERE stock_out_id =:id');
        $this->db->bind(':id', $id);
        $x = $this->db->single();
        return $x;
    }
 public function saveTheSalesTempData_stock_out_for_edit($st_order)
    {
        $s = $st_order;
        $d_item_id = explode("|||", $s->item_id);
        $d_item_name = explode("|||", $s->item_name); 
        $d_item_qty = explode("|||", $s->item_qty);
        $d_item_rec = explode("|||", $s->item_rec);
        $d_item_price = explode("|||", $s->item_price);
        $d_item_rtotal = explode("|||", $s->item_rtotal);
        for ($i=0; $i < sizeof($d_item_id); $i++) 
        {   
            $this->db->query('INSERT INTO temp_stock_out (item_id, item_name, s_qty, type, price, total,created_by) VALUES(:id, :name, :sQty, :rec, :price, :total,:user_id)');
            $this->db->bind(':user_id',$_SESSION['user_id']);
            $this->db->bind(':id',  $d_item_id[$i]);
            $this->db->bind(':name', $d_item_name[$i]);
            $this->db->bind(':sQty', $d_item_qty[$i]);
            $this->db->bind(':rec', $d_item_rec[$i]);
            $this->db->bind(':price',  $d_item_price[$i]);
            $this->db->bind(':total', $d_item_rtotal[$i]);
            $x = $this->db->execute();
        }
        if($x)
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }


}

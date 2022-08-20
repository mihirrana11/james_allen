<?php
session_start();
class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $_SESSION["per_page"] = "10";
        if (!isset($_SESSION["admin_email"])) {
            redirect(base_url() . 'admin_login');
        }
    }
    
    public function index()
    {
        
        //$_SESSION["per_page"]="10";
        $page_data['page_title'] = "Welcome";
        $page_data['page_name']  = 'dashboard_view';
        $this->load->view('admin/index', $page_data);
        
        //$this->load->view('admin/index');
    }

    public function product_notify_alert($product_id)
    {

        $this->db->join('tbl_customer','tbl_notify.customer_id=tbl_customer.customer_id');
        $notify_res = $this->db->get_where('tbl_notify',array('product_id'=>$product_id));
        foreach($notify_res->result() as $notify_row)
        {
            echo "<br>".$notify_row->customer_full_name;

            $notify_remove_query="delete from tbl_notify where product_id='".$product_id."' and customer_id='".$notify_row->customer_id."' ";
            //$this->db->query($notify_remove_query);

            
            $from_email='alert@vimlaprints.com';
            $mailto=$notify_row->customer_email_address;
            $subject = "Product is available now";
            $message = '<html><body>';
            $message .= '<center><p style="color:#080;font-size:18px;">Hello, Product is available</p><br>
            </center>';
            $message .= '</body></html>';

            // a random hash will be necessary to send mixed content
            $separator = md5(time());

            // carriage return type (RFC)
            $eol = "\r\n";

            // main header (multipart mandatory)
            $headers = "From: Vimla Prints <".$from_email.">" . $eol;
            //$headers .= "MIME-Version: 1.0" . $eol;
            //$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            //$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
            //$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
            //$headers .= "This is a MIME encoded message." . $eol;

            //$headers .= 'X-Mailer: PHP/' . phpversion();

            
            // $headers  = 'MIME-Version: 1.0' . "\r\n";
            // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            

            // message
            //$body = "--" . $separator . $eol;
            //$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
            //$body .= "Content-Transfer-Encoding: 8bit" . $eol;
            $body = $message . $eol;

            
            //SEND Mail
            if (mail($mailto, $subject, $body, $headers)) {
                echo "mail send ... OK"; // or use booleans here
            } else {
                echo "mail send ... ERROR!";
                print_r( error_get_last() );
            }
            //Email Code 2

            



        }

        /*

        //send notification check - product quantity
        $old_prod_qty_res=$this->db->get_where('tbl_product',array('product_id'=>$param3));
        $old_prod_qty_row=$old_prod_qty_res->result();
        $send_notification=false;
        if($old_prod_qty_row[0]->product_quantity==0)
        {
            $notify_res = $this->db->get_where('tbl_notify',array('product_id'=>$product_id));
            foreach($notify_res->result() as $notify_row)
            {
                echo "<h1>".$notify_row->customer_id."</h1>";
            }
        }
        //send notification check - product quantity

        */


        /*
        
        $from_email='alert@vimlaprints.com';
        $mailto=$_POST["txt_to_email"];
        $subject=$_POST["txt_subject"];
        $message=$_POST["txt_message"];
        

        

        
        //$mailto = $event_row[0]->event_contact_info_email;
        //$subject = 'Payment Link of Event : '.$event_row[0]->event_title;
        
        $message = '<html><body>';
        $message .= '<center><p style="color:#080;font-size:18px;">Hello, Please click on the below Link to Pay for the Event Registration and Confirm your Event</p><br>
        <a href="'.base_url().'user/payment/'.$event_id.'">Pay Now</a></center>';
        $message .= '</body></html>';

        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (RFC)
        $eol = "\r\n";

        // main header (multipart mandatory)
        $headers = "From: Vimla Prints <".$from_email.">" . $eol;
        //$headers .= "MIME-Version: 1.0" . $eol;
        //$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        //$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
        //$headers .= "This is a MIME encoded message." . $eol;

        //$headers .= 'X-Mailer: PHP/' . phpversion();

        
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        

        // message
        //$body = "--" . $separator . $eol;
        //$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
        //$body .= "Content-Transfer-Encoding: 8bit" . $eol;
        $body .= $message . $eol;

        
        //SEND Mail
        if (mail($mailto, $subject, $body, $headers)) {
            echo "mail send ... OK"; // or use booleans here
        } else {
            echo "mail send ... ERROR!";
            print_r( error_get_last() );
        }
        //Email Code 2

        */
     
    }

    public function import_export()
    {
        $page_data['page_title'] = "Import/Export";
        $page_data['page_name']  = 'import_export_view';
        $this->load->view('admin/index', $page_data);
        
    }

    public function manage_catalogue($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["catalogue_name"]=$this->input->post("txt_catalogue_name");
                if($_FILES["img_catalogue"]["error"]==0)
                {
                    $newname = $_FILES["img_catalogue"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/catalogue/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_catalogue");

                    $data["catalogue_image"]=$newname;
                        $this->smart_resize_image("files/admin/catalogue/".$newname,262,200,true, "files/admin/catalogue/thumb/".$newname,false,false);
                }
                $data["catalogue_description"]=$this->input->post("txt_catalogue_description");$data["catalogue_release_date"]=$this->input->post("txt_catalogue_release_date");$data["catalogue_status"]=$this->input->post("rdo_catalogue_status");$data["catalogue_sort_order"]=$this->input->post("txt_catalogue_sort_order");
                if($_FILES["pdf_catalogue"]["error"]==0)
                {
                    $newname = $_FILES["pdf_catalogue"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/catalogue/";
                        $config["allowed_types"]="pdf|doc|docx";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("pdf_catalogue");

                    $data["catalogue_pdf"]=$newname;
                }
                
            $this->db->insert("tbl_catalogue",$data);

            //$current_id=$this->db->insert_id();
            //cmb_products

            $current_id = $this->db->insert_id();
            for($i=0;$i<count($_POST["cmb_products"]);$i++)
            {
                $catalogue_prod_data['product_id'] = $_POST["cmb_products"][$i];
                $catalogue_prod_data['catalogue_id'] =$current_id;
                $this->db->insert('tbl_catalogue_product',$catalogue_prod_data);
            }

            redirect(base_url()."admin/manage_catalogue");
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["catalogue_name"]=$this->input->post("txt_catalogue_name");
                if($_FILES["img_catalogue"]["error"]==0)
                {
                    $newname = $_FILES["img_catalogue"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/catalogue/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_catalogue");

                    $data["catalogue_image"]=$newname;
                        $this->smart_resize_image("files/admin/catalogue/".$newname,262,200,true, "files/admin/catalogue/thumb/".$newname,false,false);
                }
                $data["catalogue_description"]=$this->input->post("txt_catalogue_description");$data["catalogue_release_date"]=$this->input->post("txt_catalogue_release_date");$data["catalogue_status"]=$this->input->post("rdo_catalogue_status");$data["catalogue_sort_order"]=$this->input->post("txt_catalogue_sort_order");
                if($_FILES["pdf_catalogue"]["error"]==0)
                {
                    $newname = $_FILES["pdf_catalogue"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/catalogue/";
                        $config["allowed_types"]="pdf|doc|docx";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("pdf_catalogue");

                    $data["catalogue_pdf"]=$newname;
                }
                
            $this->db->where("catalogue_id",$param3);
            $this->db->update("tbl_catalogue",$data);


            $this->db->where('catalogue_id',$param3);
            $this->db->delete('tbl_catalogue_product');

            for($i=0;$i<count($_POST["cmb_products"]);$i++)
            {
                $catalogue_prod_data['product_id'] = $_POST["cmb_products"][$i];
                $catalogue_prod_data['catalogue_id'] =$param3;
                $this->db->insert('tbl_catalogue_product',$catalogue_prod_data);
            }

            redirect(base_url()."admin/manage_catalogue");
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_catalogue",array("catalogue_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("catalogue_id",$param2);
            $this->db->delete("tbl_catalogue");
            redirect(base_url()."admin/manage_catalogue");
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("catalogue_name", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_catalogue");
                $resultset=$this->db->get("tbl_catalogue");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_catalogue");
                $resultset=$this->db->get("tbl_catalogue");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_catalogue",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Catalogue View";
        $page_data["page_name"]="catalogue_view";

        $this->load->view("admin/index",$page_data);
    } 

    public function manage_block($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["block_title"]=$this->input->post("txt_block_title");$data["block_desc"]=$this->input->post("txt_block_desc");$data["block_group"]=$this->input->post("rdo_block_group");$data["block_columns"]=$this->input->post("rdo_block_columns");$data["block_order"]=$this->input->post("txt_block_order");
                if($_FILES["img_block"]["error"]==0)
                {
                    $newname = $_FILES["img_block"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/block/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_block");

                    $data["block_image"]=$newname;
                        $this->smart_resize_image("files/admin/block/".$newname,262,200,true, "files/admin/block/thumb/".$newname,false,false);
                }
                
                if($_FILES["img_block_background"]["error"]==0)
                {
                    $newname = $_FILES["img_block_background"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/block/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_block_background");

                    $data["block_background_image"]=$newname;
                        $this->smart_resize_image("files/admin/block/".$newname,262,200,true, "files/admin/block/thumb/".$newname,false,false);
                }
                $data["block_background_color"]=$this->input->post("txt_block_background_color");$data["block_status"]=$this->input->post("rdo_block_status");
            $this->db->insert("tbl_block",$data);
            redirect(base_url()."admin/manage_block");
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["block_title"]=$this->input->post("txt_block_title");$data["block_desc"]=$this->input->post("txt_block_desc");$data["block_group"]=$this->input->post("rdo_block_group");$data["block_columns"]=$this->input->post("rdo_block_columns");$data["block_order"]=$this->input->post("txt_block_order");
                if($_FILES["img_block"]["error"]==0)
                {
                    $newname = $_FILES["img_block"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/block/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_block");

                    $data["block_image"]=$newname;
                        $this->smart_resize_image("files/admin/block/".$newname,262,200,true, "files/admin/block/thumb/".$newname,false,false);
                }
                
                if($_FILES["img_block_background"]["error"]==0)
                {
                    $newname = $_FILES["img_block_background"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/block/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_block_background");

                    $data["block_background_image"]=$newname;
                        $this->smart_resize_image("files/admin/block/".$newname,262,200,true, "files/admin/block/thumb/".$newname,false,false);
                }
                $data["block_background_color"]=$this->input->post("txt_block_background_color");$data["block_status"]=$this->input->post("rdo_block_status");
            $this->db->where("block_id",$param3);
            $this->db->update("tbl_block",$data);
            redirect(base_url()."admin/manage_block");
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_block",array("block_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("block_id",$param2);
            $this->db->delete("tbl_block");
            redirect(base_url()."admin/manage_block");
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("block_title", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_block");
                $resultset=$this->db->get("tbl_block");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_block");
                $resultset=$this->db->get("tbl_block");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_block",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Block View";
        $page_data["page_name"]="block_view";

        $this->load->view("admin/index",$page_data);
    } 

    
    public function manage_product_additional_image($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["product_id"]=$this->input->post("txt_product_id");
                if($_FILES["img_product"]["error"]==0)
                {
                    $newname = $_FILES["img_product"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/product/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_product");

                    $data["product_additional_image"]=$newname;
                    //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
                }
                
            $this->db->insert("tbl_product_additional_image",$data);
            //redirect(base_url()."admin/manage_product_additional_image");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["product_id"]=$this->input->post("txt_product_id");
                if($_FILES["img_product"]["error"]==0)
                {
                    $newname = $_FILES["img_product"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/product/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_product");

                    $data["product_additional_image"]=$newname;
                    //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
                }
                
            $this->db->where("product_additional_image_id",$param3);
            $this->db->update("tbl_product_additional_image",$data);
            //redirect(base_url()."admin/manage_product_additional_image");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_product_additional_image",array("product_additional_image_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("product_additional_image_id",$param2);
            $this->db->delete("tbl_product_additional_image");
            //redirect(base_url()."admin/manage_product_additional_image");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
                //$this->db->limit($per_page,$param1);

                $page_data['pr_id']=0;
                $product_id=0;
                if(isset($param1) && trim($param1)!= "")
                {
                    $product_id=$param1;
                    $page_data['pr_id']=$param1;
                }
                
                   
                $page_data["resultset"]=$this->db->get_where("tbl_product_additional_image",array('product_id'=>$product_id));
                $resultset=$this->db->get("tbl_product_additional_image");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                //$page_data["paging_string"]=$this->paging_init("manage_product_additional_image",$total_rows,$per_page);
                
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Product Additional Image";
        $page_data["page_name"]="product_additional_image_view";

        $this->load->view("admin/index",$page_data);
    } 

    public function manage_tag($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["tag_name"]=$this->input->post("txt_tag_name");
            $this->db->insert("tbl_tag",$data);
            redirect(base_url()."admin/manage_tag");
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["tag_name"]=$this->input->post("txt_tag_name");
            $this->db->where("tag_id",$param3);
            $this->db->update("tbl_tag",$data);
            redirect(base_url()."admin/manage_tag");
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_tag",array("tag_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("tag_id",$param2);
            $this->db->delete("tbl_tag");
            redirect(base_url()."admin/manage_tag");
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("tag_name", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_tag");
                $resultset=$this->db->get("tbl_tag");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_tag");
                $resultset=$this->db->get("tbl_tag");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_tag",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Tag View";
        $page_data["page_name"]="tag_view";

        $this->load->view("admin/index",$page_data);
    } 
    
    public function manage_sms_provider($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["sms_provider_name"]     = $this->input->post("txt_sms_provider_name");
            $data["sms_provider_url"]      = $this->input->post("txt_sms_provider_url");
            $data["sms_provider_user"]     = $this->input->post("txt_sms_provider_username");
            $data["sms_provider_password"] = $this->input->post("txt_sms_provider_password");
            $data["sms_provider_status"]   = $this->input->post("rdo_sms_provider_status");
            $this->db->insert("tbl_sms_provider", $data);
            redirect(base_url() . "admin/manage_sms_provider");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["sms_provider_name"]     = $this->input->post("txt_sms_provider_name");
            $data["sms_provider_url"]      = $this->input->post("txt_sms_provider_url");
            $data["sms_provider_user"]     = $this->input->post("txt_sms_provider_username");
            $data["sms_provider_password"] = $this->input->post("txt_sms_provider_password");
            $data["sms_provider_status"]   = $this->input->post("rdo_sms_provider_status");
            $this->db->where("sms_provider_id", $param3);
            $this->db->update("tbl_sms_provider", $data);
            redirect(base_url() . "admin/manage_sms_provider");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_sms_provider", array(
                "sms_provider_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("sms_provider_id", $param2);
            $this->db->delete("tbl_sms_provider");
            redirect(base_url() . "admin/manage_sms_provider");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("sms_provider_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_sms_provider");
            $resultset                = $this->db->get("tbl_sms_provider");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_sms_provider");
            $resultset                  = $this->db->get("tbl_sms_provider");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_sms_provider", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "SMS Provider View";
        $page_data["page_name"]      = "sms_provider_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_slider($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["slider_title"]               = $this->input->post("txt_slider_title");
            $data["slider_title_text_color"]    = $this->input->post("txt_slider_text_color");
            $data["slider_subtitle"]            = $this->input->post("txt_slider_subtitle");
            $data["slider_subtitle_text_color"] = $this->input->post("txt_slider_subtitle_color");
            $data["slider_link"]                = $this->input->post("txt_slider_link");
            if ($_FILES["img_slider"]["error"] == 0) {
                $newname = $_FILES["img_slider"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/slider/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_slider");
                
                $data["slider_image"] = $newname;
                $this->smart_resize_image("files/admin/slider/" . $newname, 262, 200, true, "files/admin/slider/thumb/" . $newname, false, false);
            }
            $data["slider_order"] = $this->input->post("txt_slider_order");
            if ($_FILES["img_slider_thumbnail"]["error"] == 0) {
                $newname = $_FILES["img_slider_thumbnail"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/slider/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_slider_thumbnail");
                
                $data["slider_thumbnail"] = $newname;
                $this->smart_resize_image("files/admin/slider/" . $newname, 262, 200, true, "files/admin/slider/thumb/" . $newname, false, false);
            }
            
            $this->db->insert("tbl_slider", $data);
            redirect(base_url() . "admin/manage_slider");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["slider_title"]               = $this->input->post("txt_slider_title");
            $data["slider_title_text_color"]    = $this->input->post("txt_slider_text_color");
            $data["slider_subtitle"]            = $this->input->post("txt_slider_subtitle");
            $data["slider_subtitle_text_color"] = $this->input->post("txt_slider_subtitle_color");
            $data["slider_link"]                = $this->input->post("txt_slider_link");
            if ($_FILES["img_slider"]["error"] == 0) {
                $newname = $_FILES["img_slider"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/slider/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_slider");
                
                $data["slider_image"] = $newname;
                $this->smart_resize_image("files/admin/slider/" . $newname, 262, 200, true, "files/admin/slider/thumb/" . $newname, false, false);
            }
            $data["slider_order"] = $this->input->post("txt_slider_order");
            if ($_FILES["img_slider_thumbnail"]["error"] == 0) {
                $newname = $_FILES["img_slider_thumbnail"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/slider/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_slider_thumbnail");
                
                $data["slider_thumbnail"] = $newname;
                $this->smart_resize_image("files/admin/slider/" . $newname, 262, 200, true, "files/admin/slider/thumb/" . $newname, false, false);
            }
            
            $this->db->where("slider_id", $param3);
            $this->db->update("tbl_slider", $data);
            redirect(base_url() . "admin/manage_slider");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_slider", array(
                "slider_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("slider_id", $param2);
            $this->db->delete("tbl_slider");
            redirect(base_url() . "admin/manage_slider");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("slider_title", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_slider");
            $resultset                = $this->db->get("tbl_slider");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_slider");
            $resultset                  = $this->db->get("tbl_slider");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_slider", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Slider View";
        $page_data["page_name"]      = "slider_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_role_type($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["role_type_name"]   = $this->input->post("txt_role_type_name");
            $data["role_type_status"] = $this->input->post("rdo_role_type_status");
            $this->db->insert("tbl_role_type", $data);
            redirect(base_url() . "admin/manage_role_type");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["role_type_name"]   = $this->input->post("txt_role_type_name");
            $data["role_type_status"] = $this->input->post("rdo_role_type_status");
            $this->db->where("role_type_id", $param3);
            $this->db->update("tbl_role_type", $data);
            redirect(base_url() . "admin/manage_role_type");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_role_type", array(
                "role_type_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("role_type_id", $param2);
            $this->db->delete("tbl_role_type");
            redirect(base_url() . "admin/manage_role_type");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("role_type_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_role_type");
            $resultset                = $this->db->get("tbl_role_type");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_role_type");
            $resultset                  = $this->db->get("tbl_role_type");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_role_type", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Role Type View";
        $page_data["page_name"]      = "role_type_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    
    public function manage_menu($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["menu_name"]=$this->input->post("txt_menu_name");$data["menu_title"]=$this->input->post("txt_menu_title");$data["menu_url"]=$this->input->post("txt_menu_url");$data["menu_display"]=$this->input->post("rdo_menu_display");$data["menu_sort_order"]=$this->input->post("txt_menu_sort_order");
            $this->db->insert("tbl_menu",$data);
            redirect(base_url()."admin/manage_menu");
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["menu_name"]=$this->input->post("txt_menu_name");$data["menu_title"]=$this->input->post("txt_menu_title");$data["menu_url"]=$this->input->post("txt_menu_url");$data["menu_display"]=$this->input->post("rdo_menu_display");$data["menu_sort_order"]=$this->input->post("txt_menu_sort_order");
            $this->db->where("menu_id",$param3);
            $this->db->update("tbl_menu",$data);
            redirect(base_url()."admin/manage_menu");
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_menu",array("menu_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("menu_id",$param2);
            $this->db->delete("tbl_menu");
            redirect(base_url()."admin/manage_menu");
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("menu_name", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_menu");
                $resultset=$this->db->get("tbl_menu");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_menu");
                $resultset=$this->db->get("tbl_menu");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_menu",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Menu View";
        $page_data["page_name"]="menu_view";

        $this->load->view("admin/index",$page_data);
    } 

    public function manage_submenu($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["submenu_name"]=$this->input->post("txt_submenu_name");$data["submenu_title"]=$this->input->post("txt_submenu_title");$data["submenu_url"]=$this->input->post("txt_submenu_url");$data["submenu_display"]=$this->input->post("rdo_submenu_display");$data["submenu_sort_order"]=$this->input->post("txt_submenu_sort_order");$data["menu_id"]=$this->input->post("txt_menu_id");
            $this->db->insert("tbl_submenu",$data);
            redirect(base_url()."admin/manage_submenu");
        }
        if($param1=="edit" && $param2=="do_update")
        {
            $data["submenu_name"]=$this->input->post("txt_submenu_name");$data["submenu_title"]=$this->input->post("txt_submenu_title");$data["submenu_url"]=$this->input->post("txt_submenu_url");$data["submenu_display"]=$this->input->post("rdo_submenu_display");$data["submenu_sort_order"]=$this->input->post("txt_submenu_sort_order");$data["menu_id"]=$this->input->post("txt_menu_id");
            $this->db->where("submenu_id",$param3);
            $this->db->update("tbl_submenu",$data);
            redirect(base_url()."admin/manage_submenu");
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_submenu",array("submenu_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("submenu_id",$param2);
            $this->db->delete("tbl_submenu");
            redirect(base_url()."admin/manage_submenu");
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("submenu_name", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_submenu");
                $resultset=$this->db->get("tbl_submenu");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_submenu");
                $resultset=$this->db->get("tbl_submenu");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_submenu",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Submenu View";
        $page_data["page_name"]="submenu_view";

        $this->load->view("admin/index",$page_data);
    } 
    
    /*
    public function manage_product($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            print("<pre>");
            print_r($_POST);
            print("</pre>");
            
            $data["product_name"]                   = $this->input->post("txt_product_name");
            $data["product_model_number"]           = $this->input->post("txt_product_model_number");
            $data["product_stock"]                  = $this->input->post("txt_product_stock");
            $data["product_brief_description"]      = $this->input->post("txt_product_brief_description");
            $data["product_full_description"]       = $this->input->post("txt_product_full_description");
            $data["product_additional_information"] = $this->input->post("txt_product_additional_info");
            if ($_FILES["img_product"]["error"] == 0) {
                $newname = $_FILES["img_product"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/product/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_product");
                
                $data["product_image"] = $newname;
                //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                
                $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
            }
            $data["product_mrp"]           = $this->input->post("txt_product_mrp");
            $data["product_selling_price"] = $this->input->post("txt_product_selling_price");
            $this->db->insert("tbl_product", $data);
            redirect(base_url() . "admin/manage_product");
            
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["product_name"]                   = $this->input->post("txt_product_name");
            $data["product_model_number"]           = $this->input->post("txt_product_model_number");
            $data["product_stock"]                  = $this->input->post("txt_product_stock");
            $data["product_brief_description"]      = $this->input->post("txt_product_brief_description");
            $data["product_full_description"]       = $this->input->post("txt_product_full_description");
            $data["product_additional_information"] = $this->input->post("txt_product_additional_info");
            if ($_FILES["img_product"]["error"] == 0) {
                $newname = $_FILES["img_product"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/product/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_product");
                
                $data["product_image"] = $newname;
                //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
            }
            $data["product_mrp"]           = $this->input->post("txt_product_mrp");
            $data["product_selling_price"] = $this->input->post("txt_product_selling_price");
            $this->db->where("product_id", $param3);
            $this->db->update("tbl_product", $data);
            redirect(base_url() . "admin/manage_product");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_product", array(
                "product_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("product_id", $param2);
            $this->db->delete("tbl_product");
            redirect(base_url() . "admin/manage_product");
        }
        
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("product_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_product");
            $resultset                = $this->db->get("tbl_product");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_product");
            $resultset                  = $this->db->get("tbl_product");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_product", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Product View";
        $page_data["page_name"]      = "product_view";
        
        $this->load->view("admin/index", $page_data);
    }
    */

    public function manage_product($param1="",$param2="",$param3="")
    {
        if($param1=="create")
        {
            $data["product_name"]=$this->input->post("txt_product_name");$data["product_description"]=$this->input->post("txt_product_description");$data["product_meta_title"]=$this->input->post("txt_product_meta_title");$data["product_meta_tag_keywords"]=$this->input->post("txt_product_meta_tag_keywords");$data["product_meta_tag_description"]=$this->input->post("txt_product_meta_tag_description");$data["product_model_no"]=$this->input->post("txt_product_model_no");$data["product_sku"]=$this->input->post("txt_product_sku");$data["product_upc"]=$this->input->post("txt_product_upc");$data["product_ean"]=$this->input->post("txt_product_ean");$data["product_jan"]=$this->input->post("txt_product_jan");$data["product_isbn"]=$this->input->post("txt_product_isbn");$data["product_mpn"]=$this->input->post("txt_product_mpn");$data["product_mrp"]=$this->input->post("txt_product_mrp");$data["product_selling_price"]=$this->input->post("txt_product_selling_price");$data["product_tax_class"]=$this->input->post("rdo_product_tax_class");$data["product_quantity"]=$this->input->post("txt_product_quantity");$data["product_min_quantity"]=$this->input->post("txt_product_min_quantity");$data["product_out_of_stock_status"]=$this->input->post("rdo_product_out_of_stock_status");$data["product_require_shipping"]=$this->input->post("rdo_product_require_shipping");$data["product_available_date"]=$this->input->post("txt_product_available_date");$data["product_dimension_length"]=$this->input->post("txt_product_dimension_length");$data["product_dimension_width"]=$this->input->post("txt_product_dimension_width");$data["product_dimension_height"]=$this->input->post("txt_product_dimension_height");$data["product_length_class"]=$this->input->post("rdo_product_length_class");$data["product_weight_class"]=$this->input->post("rdo_product_weight_class");$data["product_weight"]=$this->input->post("txt_product_weight");$data["product_status"]=$this->input->post("rdo_product_status");$data["product_sort_order"]=$this->input->post("txt_product_sort_order");
                if($_FILES["img_product"]["error"]==0)
                {
                    $newname = $_FILES["img_product"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/product/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_product");

                    $data["product_image"]=$newname;
                    //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
                }
                $data["product_seo_slug"]=$this->input->post("txt_product_seo_slug");$data["product_is_bundled"]=$this->input->post("rdo_product_is_bundled");$data["manufacturer_id"]=$this->input->post("txt_manufacturer_id");$data["category_id"]=$this->input->post("txt_category_id");
            $this->db->insert("tbl_product_new",$data);

            //$this->db->insert("tbl_category", $data);
            $current_prod_id = $this->db->insert_id();
            for($i=0;$i<count($_POST["cmb_category"]);$i++)
            {
                $prod_cat_data['category_id'] = $_POST["cmb_category"][$i];
                $prod_cat_data['product_id'] =$current_prod_id;
                $this->db->insert('tbl_product_category',$prod_cat_data);
            }

            //redirect(base_url()."admin/manage_product");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        if($param1=="edit" && $param2=="do_update")
        {
            
            // check old quantity to send email to notifier
            $old_prod_qty_res=$this->db->get_where('tbl_product_new',array('product_id'=>$param3));
            $old_prod_qty_row=$old_prod_qty_res->result();
            if($old_prod_qty_row[0]->product_quantity==0 && $this->input->post('txt_product_quantity')!=0)
            {
                $this->product_notify_alert($param3);
            }
            // check old quantity to send email to notifier


        

            $data["product_name"]=$this->input->post("txt_product_name");$data["product_description"]=$this->input->post("txt_product_description");$data["product_meta_title"]=$this->input->post("txt_product_meta_title");$data["product_meta_tag_keywords"]=$this->input->post("txt_product_meta_tag_keywords");$data["product_meta_tag_description"]=$this->input->post("txt_product_meta_tag_description");$data["product_model_no"]=$this->input->post("txt_product_model_no");$data["product_sku"]=$this->input->post("txt_product_sku");$data["product_upc"]=$this->input->post("txt_product_upc");$data["product_ean"]=$this->input->post("txt_product_ean");$data["product_jan"]=$this->input->post("txt_product_jan");$data["product_isbn"]=$this->input->post("txt_product_isbn");$data["product_mpn"]=$this->input->post("txt_product_mpn");$data["product_mrp"]=$this->input->post("txt_product_mrp");$data["product_selling_price"]=$this->input->post("txt_product_selling_price");$data["product_tax_class"]=$this->input->post("rdo_product_tax_class");$data["product_quantity"]=$this->input->post("txt_product_quantity");$data["product_min_quantity"]=$this->input->post("txt_product_min_quantity");$data["product_out_of_stock_status"]=$this->input->post("rdo_product_out_of_stock_status");$data["product_require_shipping"]=$this->input->post("rdo_product_require_shipping");$data["product_available_date"]=$this->input->post("txt_product_available_date");$data["product_dimension_length"]=$this->input->post("txt_product_dimension_length");$data["product_dimension_width"]=$this->input->post("txt_product_dimension_width");$data["product_dimension_height"]=$this->input->post("txt_product_dimension_height");$data["product_length_class"]=$this->input->post("rdo_product_length_class");$data["product_weight_class"]=$this->input->post("rdo_product_weight_class");$data["product_weight"]=$this->input->post("txt_product_weight");$data["product_status"]=$this->input->post("rdo_product_status");$data["product_sort_order"]=$this->input->post("txt_product_sort_order");
                if($_FILES["img_product"]["error"]==0)
                {
                    $newname = $_FILES["img_product"]["name"];
                    $newname = $this->generate_random_name($newname);
                    
                    $config["file_name"]=$newname;
                    $config["upload_path"]="files/admin/product/";
                        $config["allowed_types"]="gif|jpg|png|bmp|jpeg|ico|jpeg";
                    $config["max_width"]="102400";
                    $config["max_height"]="76800";
                    $config["max_size"]=1024*1024*2;
                    
                    $this->load->library("upload");
                    $this->upload->initialize($config);
                    $this->upload->do_upload("img_product");

                    $data["product_image"]=$newname;
                    //$this->smart_resize_image("files/admin/product/".$newname,262,200,true, "files/admin/product/thumb/".$newname,false,false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 1200, 1200, true, "files/admin/product/big/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 700, 700, true, "files/admin/product/med/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 250, 250, true, "files/admin/product/small/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 150, 150, true, "files/admin/product/thumb/" . $newname, false, false);
                    $this->smart_resize_image("files/admin/product/" . $newname, 100, 100, true, "files/admin/product/thumb_small/" . $newname, false, false);
                }
                $data["product_seo_slug"]=$this->input->post("txt_product_seo_slug");$data["product_is_bundled"]=$this->input->post("rdo_product_is_bundled");$data["manufacturer_id"]=$this->input->post("txt_manufacturer_id");$data["category_id"]=$this->input->post("txt_category_id");
            $this->db->where("product_id",$param3);
            $this->db->update("tbl_product_new",$data);


            

            //$this->db->insert("tbl_category", $data);
            $this->db->where('product_id',$param3);
            $this->db->delete('tbl_product_category');

            for($i=0;$i<count($_POST["cmb_category"]);$i++)
            {
                $prod_cat_data['category_id'] = $_POST["cmb_category"][$i];
                $prod_cat_data['product_id'] =$param3;
                $this->db->insert('tbl_product_category',$prod_cat_data);
            }

            //redirect(base_url()."admin/manage_product");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        else if($param1=="edit")
        {
            $page_data["edit_profile"]=$this->db->get_where("tbl_product_new",array("product_id"=>$param2));
        }
        if($param1=="delete")
        {
            $this->db->where("product_id",$param2);
            $this->db->delete("tbl_product_new");
            //redirect(base_url()."admin/manage_product");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }

        /* paging starts here */
        $per_page=$_SESSION["per_page"];

        
            if($param1=="search" && trim($this->input->post("txt_search"))!="")
            {
                $search = trim($this->input->post("txt_search"));
                $search = htmlspecialchars($search);
                $this->db->like("product_name", $search,"after");
                
                $page_data["resultset"]=$this->db->get("tbl_product_new");
                $resultset=$this->db->get("tbl_product_new");
                $total_rows=$resultset->num_rows();
                $page_data["search_data"]=$search;          
               }
            else
            {
                   $this->db->limit($per_page,$param1);
                   
                $page_data["resultset"]=$this->db->get("tbl_product_new");
                $resultset=$this->db->get("tbl_product_new");
                $total_rows=$resultset->num_rows();
                   $page_data["search_data"]="";           
                $page_data["paging_string"]=$this->paging_init("manage_product",$total_rows,$per_page);
              }
        
        $page_data["start_position"]=intval($param1)+1;    
        $page_data["page_title"]="Product View";
        $page_data["page_name"]="product_view";

        $this->load->view("admin/index",$page_data);
    } 
    
    public function manage_page($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["page_title"]         = $this->input->post("txt_page_title");
            $data["page_view_position"] = $this->input->post("txt_page_view_position");
            $data["page_slug"]          = $this->input->post("txt_page_slug");
            $data["page_content"]       = $this->input->post("txt_page_content");
            $data["page_publish_at"]    = $this->input->post("txt_page_publish_at");
            $data["page_visibility"]    = $this->input->post("rdo_page_visibility");
            if ($_FILES["img_product"]["error"] == 0) {
                $newname = $_FILES["img_product"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/page/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_product");
                
                $data["page_featured_image"] = $newname;
                $this->smart_resize_image("files/admin/page/" . $newname, 262, 200, true, "files/admin/page/thumb/" . $newname, false, false);
            }
            
            $this->db->insert("tbl_page", $data);
            redirect(base_url() . "admin/manage_page");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["page_title"]         = $this->input->post("txt_page_title");
            $data["page_view_position"] = $this->input->post("txt_page_view_position");
            $data["page_slug"]          = $this->input->post("txt_page_slug");
            $data["page_content"]       = $this->input->post("txt_page_content");
            $data["page_publish_at"]    = $this->input->post("txt_page_publish_at");
            $data["page_visibility"]    = $this->input->post("rdo_page_visibility");
            if ($_FILES["img_product"]["error"] == 0) {
                $newname = $_FILES["img_product"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/page/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_product");
                
                $data["page_featured_image"] = $newname;
                $this->smart_resize_image("files/admin/page/" . $newname, 262, 200, true, "files/admin/page/thumb/" . $newname, false, false);
            }
            
            $this->db->where("page_id", $param3);
            $this->db->update("tbl_page", $data);
            redirect(base_url() . "admin/manage_page");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_page", array(
                "page_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("page_id", $param2);
            $this->db->delete("tbl_page");
            redirect(base_url() . "admin/manage_page");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("page_title", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_page");
            $resultset                = $this->db->get("tbl_page");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_page");
            $resultset                  = $this->db->get("tbl_page");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_page", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Page View";
        $page_data["page_name"]      = "page_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_manufacturer($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["manufacturer_name"] = $this->input->post("txt_manufacturer_name");
            if ($_FILES["img_manufacturer"]["error"] == 0) {
                $newname = $_FILES["img_manufacturer"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/manufacturer/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_manufacturer");
                
                $data["manufacturer_image"] = $newname;
                $this->smart_resize_image("files/admin/manufacturer/" . $newname, 262, 200, true, "files/admin/manufacturer/thumb/" . $newname, false, false);
            }
            $data["manufacturer_description"] = $this->input->post("txt_manufacturer_description");
            $this->db->insert("tbl_manufacturer", $data);
            redirect(base_url() . "admin/manage_manufacturer");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["manufacturer_name"] = $this->input->post("txt_manufacturer_name");
            if ($_FILES["img_manufacturer"]["error"] == 0) {
                $newname = $_FILES["img_manufacturer"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/manufacturer/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_manufacturer");
                
                $data["manufacturer_image"] = $newname;
                $this->smart_resize_image("files/admin/manufacturer/" . $newname, 262, 200, true, "files/admin/manufacturer/thumb/" . $newname, false, false);
            }
            $data["manufacturer_description"] = $this->input->post("txt_manufacturer_description");
            $this->db->where("manufacturer_id", $param3);
            $this->db->update("tbl_manufacturer", $data);
            redirect(base_url() . "admin/manage_manufacturer");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_manufacturer", array(
                "manufacturer_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("manufacturer_id", $param2);
            $this->db->delete("tbl_manufacturer");
            redirect(base_url() . "admin/manage_manufacturer");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("manufacturer_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_manufacturer");
            $resultset                = $this->db->get("tbl_manufacturer");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_manufacturer");
            $resultset                  = $this->db->get("tbl_manufacturer");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_manufacturer", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Manufacturer View";
        $page_data["page_name"]      = "manufacturer_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_faq($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["faq_question"] = $this->input->post("txt_faq_question");
            $data["faq_answer"]   = $this->input->post("txt_faq_answer");
            $data["faq_topic_id"] = $this->input->post("cmb_faq_topic");
            $this->db->insert("tbl_faq", $data);
            redirect(base_url() . "admin/manage_faq");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["faq_question"] = $this->input->post("txt_faq_question");
            $data["faq_answer"]   = $this->input->post("txt_faq_answer");
            $data["faq_topic_id"] = $this->input->post("cmb_faq_topic");
            $this->db->where("faq_id", $param3);
            $this->db->update("tbl_faq", $data);
            redirect(base_url() . "admin/manage_faq");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_faq", array(
                "faq_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("faq_id", $param2);
            $this->db->delete("tbl_faq");
            redirect(base_url() . "admin/manage_faq");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("faq_question", $search, "after");
            $this->db->join("tbl_faq_topic", "tbl_faq.faq_topic_id=tbl_faq_topic.faq_topic_id");
            $page_data["resultset"]   = $this->db->get("tbl_faq");
            $resultset                = $this->db->get("tbl_faq");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            $this->db->join("tbl_faq_topic", "tbl_faq.faq_topic_id=tbl_faq_topic.faq_topic_id");
            $page_data["resultset"]     = $this->db->get("tbl_faq");
            $resultset                  = $this->db->get("tbl_faq");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_faq", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "FAQ View";
        $page_data["page_name"]      = "faq_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_faq_topic($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["faq_topic_name"] = $this->input->post("txt_faq_topic_name");
            $data["faq_topic_for"]  = $this->input->post("rdo_faq_topic_for");
            $this->db->insert("tbl_faq_topic", $data);
            redirect(base_url() . "admin/manage_faq_topic");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["faq_topic_name"] = $this->input->post("txt_faq_topic_name");
            $data["faq_topic_for"]  = $this->input->post("rdo_faq_topic_for");
            $this->db->where("faq_topic_id", $param3);
            $this->db->update("tbl_faq_topic", $data);
            redirect(base_url() . "admin/manage_faq_topic");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_faq_topic", array(
                "faq_topic_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("faq_topic_id", $param2);
            $this->db->delete("tbl_faq_topic");
            redirect(base_url() . "admin/manage_faq_topic");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("faq_topic_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_faq_topic");
            $resultset                = $this->db->get("tbl_faq_topic");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_faq_topic");
            $resultset                  = $this->db->get("tbl_faq_topic");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_faq_topic", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "FAQ Topic View";
        $page_data["page_name"]      = "faq_topic_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_email_template($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["email_template_name"]         = $this->input->post("txt_email_template");
            $data["email_template_type"]         = $this->input->post("rdo_email_template_type");
            $data["email_template_for"]          = $this->input->post("rdo_email_template_for");
            $data["email_template_sender_email"] = $this->input->post("txt_email_template_sender_email");
            $data["email_template_sender_name"]  = $this->input->post("txt_email_template_sender_name");
            $data["email_template_subject"]      = $this->input->post("txt_email_template_subject");
            $data["email_template_body"]         = $this->input->post("txt_email_template_body");
            $this->db->insert("tbl_email_template", $data);
            redirect(base_url() . "admin/manage_email_template");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["email_template_name"]         = $this->input->post("txt_email_template");
            $data["email_template_type"]         = $this->input->post("rdo_email_template_type");
            $data["email_template_for"]          = $this->input->post("rdo_email_template_for");
            $data["email_template_sender_email"] = $this->input->post("txt_email_template_sender_email");
            $data["email_template_sender_name"]  = $this->input->post("txt_email_template_sender_name");
            $data["email_template_subject"]      = $this->input->post("txt_email_template_subject");
            $data["email_template_body"]         = $this->input->post("txt_email_template_body");
            $this->db->where("email_template_id", $param3);
            $this->db->update("tbl_email_template", $data);
            redirect(base_url() . "admin/manage_email_template");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_email_template", array(
                "email_template_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("email_template_id", $param2);
            $this->db->delete("tbl_email_template");
            redirect(base_url() . "admin/manage_email_template");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("email_template_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_email_template");
            $resultset                = $this->db->get("tbl_email_template");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_email_template");
            $resultset                  = $this->db->get("tbl_email_template");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_email_template", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Email Template View";
        $page_data["page_name"]      = "email_template_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_download($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["download_file_name"] = $this->input->post("txt_download_file_name");
            if ($_FILES["file_download"]["error"] == 0) {
                $newname = $_FILES["file_download"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/download/";
                $config["allowed_types"] = "pdf|doc|docx|xls|xlsx|jpg|png|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("file_download");
                
                $data["download_file"] = $newname;
            }
            $data["download_file_mask"] = $this->input->post("txt_download_file_mask");
            $this->db->insert("tbl_download", $data);
            redirect(base_url() . "admin/manage_download");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["download_file_name"] = $this->input->post("txt_download_file_name");
            if ($_FILES["file_download"]["error"] == 0) {
                $newname = $_FILES["file_download"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/download/";
                $config["allowed_types"] = "pdf|doc|docx|xls|xlsx|jpg|png|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("file_download");
                
                $data["download_file"] = $newname;
            }
            $data["download_file_mask"] = $this->input->post("txt_download_file_mask");
            $this->db->where("download_id", $param3);
            $this->db->update("tbl_download", $data);
            redirect(base_url() . "admin/manage_download");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_download", array(
                "download_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("download_id", $param2);
            $this->db->delete("tbl_download");
            redirect(base_url() . "admin/manage_download");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("download_file_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_download");
            $resultset                = $this->db->get("tbl_download");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_download");
            $resultset                  = $this->db->get("tbl_download");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_download", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Download View";
        $page_data["page_name"]      = "download_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_customer($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["customer_full_name"]     = $this->input->post("txt_customer_name");
            $data["customer_status"]        = $this->input->post("rdo_customer_status");
            $data["customer_nickname"]      = $this->input->post("txt_customer_nickname");
            $data["customer_email_address"] = $this->input->post("txt_email_address");
            $data["customer_password"]      = $this->input->post("txt_customer_password");
            $data["customer_description"]   = $this->input->post("txt_customer_description");
            $data["customer_dob"]           = $this->input->post("txt_customer_dob");
            $data["customer_gender"]        = $this->input->post("rdo_customer_gender");
            $data["customer_address_line1"] = $this->input->post("txt_customer_address_line1");
            $data["customer_address_line2"] = $this->input->post("txt_customer_address_line2");
            $data["customer_city"]          = $this->input->post("cmb_city");
            $data["customer_postal_code"]   = $this->input->post("txt_customer_postal_code");
            $data["customer_country_id"]    = $this->input->post("cmb_customer_country");
            $data["customer_state_id"]      = $this->input->post("cmb_state");
            if ($_FILES["img_customer_profie_pic"]["error"] == 0) {
                $newname = $_FILES["img_customer_profie_pic"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/customer/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_customer_profie_pic");
                
                $data["customer_profile_pic"] = $newname;
                $this->smart_resize_image("files/admin/customer/" . $newname, 262, 200, true, "files/admin/customer/thumb/" . $newname, false, false);
            }
            $data["customer_doj"] = $this->input->post("txt_customer_doj");
            $this->db->insert("tbl_customer", $data);
            redirect(base_url() . "admin/manage_customer");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["customer_full_name"]     = $this->input->post("txt_customer_name");
            $data["customer_status"]        = $this->input->post("rdo_customer_status");
            $data["customer_nickname"]      = $this->input->post("txt_customer_nickname");
            $data["customer_email_address"] = $this->input->post("txt_email_address");
            $data["customer_password"]      = $this->input->post("txt_customer_password");
            $data["customer_description"]   = $this->input->post("txt_customer_description");
            $data["customer_dob"]           = $this->input->post("txt_customer_dob");
            $data["customer_gender"]        = $this->input->post("rdo_customer_gender");
            $data["customer_address_line1"] = $this->input->post("txt_customer_address_line1");
            $data["customer_address_line2"] = $this->input->post("txt_customer_address_line2");
            $data["customer_city"]          = $this->input->post("cmb_city");
            $data["customer_postal_code"]   = $this->input->post("txt_customer_postal_code");
            $data["customer_country_id"]    = $this->input->post("cmb_customer_country");
            $data["customer_state_id"]      = $this->input->post("cmb_state");
            if ($_FILES["img_customer_profie_pic"]["error"] == 0) {
                $newname = $_FILES["img_customer_profie_pic"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/customer/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_customer_profie_pic");
                
                $data["customer_profile_pic"] = $newname;
                $this->smart_resize_image("files/admin/customer/" . $newname, 262, 200, true, "files/admin/customer/thumb/" . $newname, false, false);
            }
            $data["customer_doj"] = $this->input->post("txt_customer_doj");
            $this->db->where("customer_id", $param3);
            $this->db->update("tbl_customer", $data);
            redirect(base_url() . "admin/manage_customer");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_customer", array(
                "customer_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("customer_id", $param2);
            $this->db->delete("tbl_customer");
            redirect(base_url() . "admin/manage_customer");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("customer_full_name", $search, "after");
            $this->db->join("tbl_city", "tbl_customer.customer_city=tbl_city.city_id");
            $this->db->join("tbl_country", "tbl_customer.customer_country_id=tbl_country.country_id");
            $this->db->join("tbl_state", "tbl_customer.customer_state_id=tbl_state.state_id");
            $page_data["resultset"]   = $this->db->get("tbl_customer");
            $resultset                = $this->db->get("tbl_customer");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            $this->db->join("tbl_city", "tbl_customer.customer_city=tbl_city.city_id");
            $this->db->join("tbl_country", "tbl_customer.customer_country_id=tbl_country.country_id");
            $this->db->join("tbl_state", "tbl_customer.customer_state_id=tbl_state.state_id");
            $page_data["resultset"]     = $this->db->get("tbl_customer");
            $resultset                  = $this->db->get("tbl_customer");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_customer", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Customer View";
        $page_data["page_name"]      = "customer_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_state($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["state_name"] = $this->input->post("txt_state_name");
            $data["state_code"] = $this->input->post("txt_state_code");
            $data["country_id"] = $this->input->post("cmb_country");
            $this->db->insert("tbl_state", $data);
            redirect(base_url() . "admin/manage_state");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["state_name"] = $this->input->post("txt_state_name");
            $data["state_code"] = $this->input->post("txt_state_code");
            $data["country_id"] = $this->input->post("cmb_country");
            $this->db->where("state_id", $param3);
            $this->db->update("tbl_state", $data);
            redirect(base_url() . "admin/manage_state");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_state", array(
                "state_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("state_id", $param2);
            $this->db->delete("tbl_state");
            redirect(base_url() . "admin/manage_state");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("state_name", $search, "after");
            $this->db->join("tbl_country", "tbl_state.country_id=tbl_country.country_id");
            $page_data["resultset"]   = $this->db->get("tbl_state");
            $resultset                = $this->db->get("tbl_state");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            $this->db->join("tbl_country", "tbl_state.country_id=tbl_country.country_id");
            $page_data["resultset"]     = $this->db->get("tbl_state");
            $resultset                  = $this->db->get("tbl_state");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_state", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "State View";
        $page_data["page_name"]      = "state_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_currency($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["currency_symbol"]             = $this->input->post("txt_currency_symbol");
            $data["currency_iso_code"]           = $this->input->post("txt_currency_iso_code");
            $data["currency_sub_unit"]           = $this->input->post("txt_currency_sub_unit");
            $data["currency_symbol_first"]       = $this->input->post("rdo_currency_symbol_first");
            $data["currency_thousands_seprator"] = $this->input->post("rdo_currency_thousands_seprator");
            $data["currency_decimal_mark"]       = $this->input->post("rdo_currency_decimal_mark");
            $this->db->insert("tbl_currency", $data);
            redirect(base_url() . "admin/manage_currency");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["currency_symbol"]             = $this->input->post("txt_currency_symbol");
            $data["currency_iso_code"]           = $this->input->post("txt_currency_iso_code");
            $data["currency_sub_unit"]           = $this->input->post("txt_currency_sub_unit");
            $data["currency_symbol_first"]       = $this->input->post("rdo_currency_symbol_first");
            $data["currency_thousands_seprator"] = $this->input->post("rdo_currency_thousands_seprator");
            $data["currency_decimal_mark"]       = $this->input->post("rdo_currency_decimal_mark");
            $this->db->where("currency_id", $param3);
            $this->db->update("tbl_currency", $data);
            redirect(base_url() . "admin/manage_currency");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_currency", array(
                "currency_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("currency_id", $param2);
            $this->db->delete("tbl_currency");
            redirect(base_url() . "admin/manage_currency");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("currency_symbol", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_currency");
            $resultset                = $this->db->get("tbl_currency");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_currency");
            $resultset                  = $this->db->get("tbl_currency");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_currency", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Currency View";
        $page_data["page_name"]      = "currency_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_coupon($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["coupon_name"]                  = $this->input->post("txt_coupon_name");
            $data["coupon_status"]                = $this->input->post("rdo_coupon_status");
            $data["coupon_code"]                  = $this->input->post("txt_coupon_code");
            $data["coupon_value"]                 = $this->input->post("txt_coupon_value");
            $data["coupon_value_on"]              = $this->input->post("rdo_coupon_value_discount_on");
            $data["coupon_quantity"]              = $this->input->post("txt_coupon_quantity");
            $data["coupon_minimum_order_amount"]  = $this->input->post("txt_coupon_min_order_amount");
            $data["coupon_quantity_per_customer"] = $this->input->post("txt_coupon_qnt_per_customer");
            $data["coupon_description"]           = $this->input->post("txt_coupon_description");
            $data["coupon_limited_ship_zone"]     = $this->input->post("rdo_coupon_limited_ship_zone");
            $data["coupon_limited_to_customer"]   = $this->input->post("rdo_coupon_limited_to_customer");
            $data["coupon_start_time"]            = $this->input->post("txt_coupon_start_date");
            $data["coupon_end_time"]              = $this->input->post("txt_coupon_end_date");
            $this->db->insert("tbl_coupon", $data);
            redirect(base_url() . "admin/manage_coupon");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["coupon_name"]                  = $this->input->post("txt_coupon_name");
            $data["coupon_status"]                = $this->input->post("rdo_coupon_status");
            $data["coupon_code"]                  = $this->input->post("txt_coupon_code");
            $data["coupon_value"]                 = $this->input->post("txt_coupon_value");
            $data["coupon_value_on"]              = $this->input->post("rdo_coupon_value_discount_on");
            $data["coupon_quantity"]              = $this->input->post("txt_coupon_quantity");
            $data["coupon_minimum_order_amount"]  = $this->input->post("txt_coupon_min_order_amount");
            $data["coupon_quantity_per_customer"] = $this->input->post("txt_coupon_qnt_per_customer");
            $data["coupon_description"]           = $this->input->post("txt_coupon_description");
            $data["coupon_limited_ship_zone"]     = $this->input->post("rdo_coupon_limited_ship_zone");
            $data["coupon_limited_to_customer"]   = $this->input->post("rdo_coupon_limited_to_customer");
            $data["coupon_start_time"]            = $this->input->post("txt_coupon_start_date");
            $data["coupon_end_time"]              = $this->input->post("txt_coupon_end_date");
            $this->db->where("coupon_id", $param3);
            $this->db->update("tbl_coupon", $data);
            redirect(base_url() . "admin/manage_coupon");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_coupon", array(
                "coupon_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("coupon_id", $param2);
            $this->db->delete("tbl_coupon");
            redirect(base_url() . "admin/manage_coupon");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("coupon_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_coupon");
            $resultset                = $this->db->get("tbl_coupon");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_coupon");
            $resultset                  = $this->db->get("tbl_coupon");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_coupon", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Coupon View";
        $page_data["page_name"]      = "coupon_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_country($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["country_name"] = $this->input->post("txt_country_name");
            $data["country_code"] = $this->input->post("txt_country_code");
            $this->db->insert("tbl_country", $data);
            redirect(base_url() . "admin/manage_country");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["country_name"] = $this->input->post("txt_country_name");
            $data["country_code"] = $this->input->post("txt_country_code");
            $this->db->where("country_id", $param3);
            $this->db->update("tbl_country", $data);
            redirect(base_url() . "admin/manage_country");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_country", array(
                "country_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("country_id", $param2);
            $this->db->delete("tbl_country");
            redirect(base_url() . "admin/manage_country");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("country_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_country");
            $resultset                = $this->db->get("tbl_country");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_country");
            $resultset                  = $this->db->get("tbl_country");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_country", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Country View";
        $page_data["page_name"]      = "country_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_city($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["city_name"] = $this->input->post("txt_city_name");
            $data["state_id"]  = $this->input->post("cmb_state");
            $this->db->insert("tbl_city", $data);
            redirect(base_url() . "admin/manage_city");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["city_name"] = $this->input->post("txt_city_name");
            $data["state_id"]  = $this->input->post("cmb_state");
            $this->db->where("city_id", $param3);
            $this->db->update("tbl_city", $data);
            redirect(base_url() . "admin/manage_city");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_city", array(
                "city_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("city_id", $param2);
            $this->db->delete("tbl_city");
            redirect(base_url() . "admin/manage_city");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("city_name", $search, "after");
            $this->db->join("tbl_state", "tbl_city.state_id=tbl_state.state_id");
            $page_data["resultset"]   = $this->db->get("tbl_city");
            $resultset                = $this->db->get("tbl_city");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            $this->db->join("tbl_state", "tbl_city.state_id=tbl_state.state_id");
            $page_data["resultset"]     = $this->db->get("tbl_city");
            $resultset                  = $this->db->get("tbl_city");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_city", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "City View";
        $page_data["page_name"]      = "city_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_admin_user($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["admin_user_name"]       = $this->input->post("txt_admin_user_name");
            $data["admin_user_pwd"]        = $this->input->post("txt_admin_user_pwd");
            $data["admin_user_email"]      = $this->input->post("txt_admin_user_email");
            $data["admin_user_phone"]      = $this->input->post("txt_admin_user_phone");
            $data["admin_user_mobile"]     = $this->input->post("txt_admin_user_mobile");
            $data["admin_user_doj"]        = $this->input->post("txt_admin_user_doj");
            $data["admin_user_last_login"] = $this->input->post("txt_admin_user_last_login");
            $this->db->insert("tbl_admin_user", $data);
            redirect(base_url() . "admin/manage_admin_user");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["admin_user_name"]       = $this->input->post("txt_admin_user_name");
            $data["admin_user_pwd"]        = $this->input->post("txt_admin_user_pwd");
            $data["admin_user_email"]      = $this->input->post("txt_admin_user_email");
            $data["admin_user_phone"]      = $this->input->post("txt_admin_user_phone");
            $data["admin_user_mobile"]     = $this->input->post("txt_admin_user_mobile");
            $data["admin_user_doj"]        = $this->input->post("txt_admin_user_doj");
            $data["admin_user_last_login"] = $this->input->post("txt_admin_user_last_login");
            $this->db->where("admin_user_id", $param3);
            $this->db->update("tbl_admin_user", $data);
            redirect(base_url() . "admin/manage_admin_user");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_admin_user", array(
                "admin_user_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("admin_user_id", $param2);
            $this->db->delete("tbl_admin_user");
            redirect(base_url() . "admin/manage_admin_user");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("admin_user_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_admin_user");
            $resultset                = $this->db->get("tbl_admin_user");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_admin_user");
            $resultset                  = $this->db->get("tbl_admin_user");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_admin_user", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Admin User View";
        $page_data["page_name"]      = "admin_user_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_blog($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["blog_title"]      = $this->input->post("txt_blog_title");
            $data["blog_slug"]       = $this->input->post("txt_blog_slug");
            $data["blog_excerpt"]    = $this->input->post("txt_blog_excerpt");
            $data["blog_content"]    = $this->input->post("txt_blog_content");
            $data["blog_publish_at"] = $this->input->post("txt_blog_publish_at");
            $data["blog_status"]     = $this->input->post("rdo_blog_status");
            if ($_FILES["img_blog"]["error"] == 0) {
                $newname = $_FILES["img_blog"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/blog/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_blog");
                
                $data["blog_image"] = $newname;
                $this->smart_resize_image("files/admin/blog/" . $newname, 262, 200, true, "files/admin/blog/thumb/" . $newname, false, false);
            }
            
            $this->db->insert("tbl_blog", $data);
            redirect(base_url() . "admin/manage_blog");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["blog_title"]      = $this->input->post("txt_blog_title");
            $data["blog_slug"]       = $this->input->post("txt_blog_slug");
            $data["blog_excerpt"]    = $this->input->post("txt_blog_excerpt");
            $data["blog_content"]    = $this->input->post("txt_blog_content");
            $data["blog_publish_at"] = $this->input->post("txt_blog_publish_at");
            $data["blog_status"]     = $this->input->post("rdo_blog_status");
            if ($_FILES["img_blog"]["error"] == 0) {
                $newname = $_FILES["img_blog"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/blog/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_blog");
                
                $data["blog_image"] = $newname;
                $this->smart_resize_image("files/admin/blog/" . $newname, 262, 200, true, "files/admin/blog/thumb/" . $newname, false, false);
            }
            
            $this->db->where("blog_id", $param3);
            $this->db->update("tbl_blog", $data);
            redirect(base_url() . "admin/manage_blog");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_blog", array(
                "blog_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("blog_id", $param2);
            $this->db->delete("tbl_blog");
            redirect(base_url() . "admin/manage_blog");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("blog_title", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_blog");
            $resultset                = $this->db->get("tbl_blog");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_blog");
            $resultset                  = $this->db->get("tbl_blog");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_blog", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Blog View";
        $page_data["page_name"]      = "blog_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_category($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["category_name"]                 = $this->input->post("txt_category_name");
            $data["category_description"]          = $this->input->post("txt_category_description");
            $data["category_seo_slug"]             = $this->input->post("txt_category_seo_slug");
            $data["category_meta_tag_title"]       = $this->input->post("txt_category_meta_tag_title");
            $data["category_meta_tag_keywords"]    = $this->input->post("txt_category_meta_tag_keywords");
            $data["category_meta_tag_description"] = $this->input->post("txt_category_meta_tag_description");
            if ($_FILES["img_category"]["error"] == 0) {
                $newname = $_FILES["img_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_category");
                
                $data["category_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            $data["category_sort_order"] = $this->input->post("txt_category_sort_order");
            $data["category_status"]     = $this->input->post("rdo_category_status");
            $data["category_fa_icon"]    = $this->input->post("txt_category_fa_icon");
            if ($_FILES["img_category"]["error"] == 0) {
                $newname = $_FILES["img_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_category");
                
                $data["category_fa_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_small_category"]["error"] == 0) {
                $newname = $_FILES["img_small_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_small_category");
                
                $data["category_small_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_banner_category"]["error"] == 0) {
                $newname = $_FILES["img_banner_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_banner_category");
                
                $data["category_banner_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_background_category"]["error"] == 0) {
                $newname = $_FILES["img_background_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_background_category");
                
                $data["category_background_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_cover_category"]["error"] == 0) {
                $newname = $_FILES["img_cover_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_cover_category");
                
                $data["category_cover_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            $data["category_show_on_home"] = $this->input->post("rdo_category_show_on_home");
            $data["category_show_on_menu"] = $this->input->post("rdo_category_show_on_menu");
            $data["parent_id"]             = $this->input->post("txt_parent_id");


            //echo count($_POST["cmb_attribute"]);


            $this->db->insert("tbl_category", $data);
            $current_cat_id = $this->db->insert_id();
            for($i=0;$i<count($_POST["cmb_attribute"]);$i++)
            {
                $cat_attr_data['attribute_id'] = $_POST["cmb_attribute"][$i];
                $cat_attr_data['category_id'] =$current_cat_id;
                $this->db->insert('tbl_category_attribute',$cat_attr_data);
            }
            
            //redirect(base_url() . "admin/manage_category");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
            
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["category_name"]                 = $this->input->post("txt_category_name");
            $data["category_description"]          = $this->input->post("txt_category_description");
            $data["category_seo_slug"]             = $this->input->post("txt_category_seo_slug");
            $data["category_meta_tag_title"]       = $this->input->post("txt_category_meta_tag_title");
            $data["category_meta_tag_keywords"]    = $this->input->post("txt_category_meta_tag_keywords");
            $data["category_meta_tag_description"] = $this->input->post("txt_category_meta_tag_description");
            if ($_FILES["img_category"]["error"] == 0) {
                $newname = $_FILES["img_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_category");
                
                $data["category_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            $data["category_sort_order"] = $this->input->post("txt_category_sort_order");
            $data["category_status"]     = $this->input->post("rdo_category_status");
            $data["category_fa_icon"]    = $this->input->post("txt_category_fa_icon");
            if ($_FILES["img_category"]["error"] == 0) {
                $newname = $_FILES["img_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_category");
                
                $data["category_fa_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_small_category"]["error"] == 0) {
                $newname = $_FILES["img_small_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_small_category");
                
                $data["category_small_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_banner_category"]["error"] == 0) {
                $newname = $_FILES["img_banner_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_banner_category");
                
                $data["category_banner_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_background_category"]["error"] == 0) {
                $newname = $_FILES["img_background_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_background_category");
                
                $data["category_background_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_cover_category"]["error"] == 0) {
                $newname = $_FILES["img_cover_category"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/category/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_cover_category");
                
                $data["category_cover_image"] = $newname;
                $this->smart_resize_image("files/admin/category/" . $newname, 262, 200, true, "files/admin/category/thumb/" . $newname, false, false);
            }
            $data["category_show_on_home"] = $this->input->post("rdo_category_show_on_home");
            $data["category_show_on_menu"] = $this->input->post("rdo_category_show_on_menu");
            $data["parent_id"]             = $this->input->post("txt_parent_id");
            $this->db->where("category_id", $param3);
            $this->db->update("tbl_category", $data);
            //redirect(base_url() . "admin/manage_category");

            $this->db->where('category_id',$param3);
            $this->db->delete('tbl_category_attribute');

            for($i=0;$i<count($_POST["cmb_attribute"]);$i++)
            {
                $cat_attr_data['attribute_id'] = $_POST["cmb_attribute"][$i];
                $cat_attr_data['category_id'] =$param3;
                $this->db->insert('tbl_category_attribute',$cat_attr_data);
            }

            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_category", array(
                "category_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("category_id", $param2);
            $this->db->delete("tbl_category");
            //redirect(base_url() . "admin/manage_category");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("category_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_category");
            $resultset                = $this->db->get("tbl_category");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            //$this->db->limit($per_page, $param1);
            $page_data['cat_id']=0;
            $parent_id=0;
            if(isset($param1) && trim($param1)!= "")
            {
                $parent_id=$param1;
                $page_data['cat_id']=$param1;
            }
            
            $page_data["resultset"]     = $this->db->get_where("tbl_category",array('parent_id'=>$parent_id));
            $resultset                  = $this->db->get("tbl_category");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            //$page_data["paging_string"] = $this->paging_init("manage_category", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Category View";
        $page_data["page_name"]      = "category_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function mange_attribute($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["attribute_type"]          = $this->input->post("rdo_attribute_type");
            $data["attribute_name"]          = $this->input->post("txt_attribute_name");
            $data["attribute_display_title"] = $this->input->post("txt_attribute_display_title");
            $data["attribute_order"]         = $this->input->post("txt_attribute_order");
            $this->db->insert("tbl_attribute", $data);
            redirect(base_url() . "admin/mange_attribute");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["attribute_type"]          = $this->input->post("rdo_attribute_type");
            $data["attribute_name"]          = $this->input->post("txt_attribute_name");
            $data["attribute_display_title"] = $this->input->post("txt_attribute_display_title");
            $data["attribute_order"]         = $this->input->post("txt_attribute_order");
            $this->db->where("attribute_id", $param3);
            $this->db->update("tbl_attribute", $data);
            redirect(base_url() . "admin/mange_attribute");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_attribute", array(
                "attribute_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("attribute_id", $param2);
            $this->db->delete("tbl_attribute");
            redirect(base_url() . "admin/mange_attribute");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("attribute_name", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_attribute");
            $resultset                = $this->db->get("tbl_attribute");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_attribute");
            $resultset                  = $this->db->get("tbl_attribute");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("mange_attribute", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Attribute View";
        $page_data["page_name"]      = "attribute_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_attribute_value($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["attribute_id"]                  = $this->input->post("txt_attribute_id");
            $data["attribute_value"]               = $this->input->post("txt_attribute_value");
            $data["attribute_value_order"]         = $this->input->post("txt_attribute_value_order");
            $data["attribute_value_color_hexcode"] = $this->input->post("txt_attribute_value_color_hexcode");
            if ($_FILES["txt_attribue_value_pattern_img"]["error"] == 0) {
                $newname = $_FILES["txt_attribue_value_pattern_img"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/pattern/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("txt_attribue_value_pattern_img");
                
                $data["attribute_value_pattern_img"] = $newname;
                $this->smart_resize_image("files/admin/pattern/" . $newname, 262, 200, true, "files/admin/pattern/thumb/" . $newname, false, false);
            }
            
            $this->db->insert("tbl_attribute_value", $data);
            //redirect(base_url() . "admin/manage_attribute_value");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["attribute_id"]                  = $this->input->post("txt_attribute_id");
            $data["attribute_value"]               = $this->input->post("txt_attribute_value");
            $data["attribute_value_order"]         = $this->input->post("txt_attribute_value_order");
            $data["attribute_value_color_hexcode"] = $this->input->post("txt_attribute_value_color_hexcode");
            if ($_FILES["txt_attribue_value_pattern_img"]["error"] == 0) {
                $newname = $_FILES["txt_attribue_value_pattern_img"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/pattern/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("txt_attribue_value_pattern_img");
                
                $data["attribute_value_pattern_img"] = $newname;
                $this->smart_resize_image("files/admin/pattern/" . $newname, 262, 200, true, "files/admin/pattern/thumb/" . $newname, false, false);
            }
            
            $this->db->where("attribute_value_id", $param3);
            $this->db->update("tbl_attribute_value", $data);
            //redirect(base_url() . "admin/manage_attribute_value");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_attribute_value", array(
                "attribute_value_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("attribute_value_id", $param2);
            $this->db->delete("tbl_attribute_value");
            //redirect(base_url() . "admin/manage_attribute_value");
            $url=$_SERVER["HTTP_REFERER"];
            redirect($url);
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("attribute_value", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_attribute_value");
            $resultset                = $this->db->get("tbl_attribute_value");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            //$this->db->limit($per_page, $param1);
            $page_data['attr_id']=0;
            $attr_id=0;
            if(isset($param1) && trim($param1)!= "")
            {
                $attr_id=$param1;
                $page_data['attr_id']=$param1;
            }

            $page_data["resultset"]     = $this->db->get_where("tbl_attribute_value",array("attribute_id"=>$attr_id));
            $resultset                  = $this->db->get("tbl_attribute_value");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            //$page_data["paging_string"] = $this->paging_init("manage_attribute_value", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Attribute Value View";
        $page_data["page_name"]      = "attribute_value_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_banner($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "create") {
            $data["banner_title"]      = $this->input->post("txt_banner_title");
            $data["banner_desc"]       = $this->input->post("txt_banner_desc");
            $data["banner_link"]       = $this->input->post("txt_banner_link");
            $data["banner_link_label"] = $this->input->post("txt_banner_link_label");
            $data["banner_group"]      = $this->input->post("rdo_banner_group");
            $data["banner_columns"]    = $this->input->post("rdo_banner_columns");
            $data["banner_order"]      = $this->input->post("txt_banner_sort_order");
            if ($_FILES["img_banner"]["error"] == 0) {
                $newname = $_FILES["img_banner"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/banner/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_banner");
                
                $data["banner_image"] = $newname;
                $this->smart_resize_image("files/admin/banner/" . $newname, 262, 200, true, "files/admin/banner/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_background_banner"]["error"] == 0) {
                $newname = $_FILES["img_background_banner"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/banner/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_background_banner");
                
                $data["banner_background_image"] = $newname;
                $this->smart_resize_image("files/admin/banner/" . $newname, 262, 200, true, "files/admin/banner/thumb/" . $newname, false, false);
            }
            $data["banner_background_color"] = $this->input->post("txt_background_color");
            $this->db->insert("tbl_banner", $data);
            redirect(base_url() . "admin/manage_banner");
        }
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["banner_title"]      = $this->input->post("txt_banner_title");
            $data["banner_desc"]       = $this->input->post("txt_banner_desc");
            $data["banner_link"]       = $this->input->post("txt_banner_link");
            $data["banner_link_label"] = $this->input->post("txt_banner_link_label");
            $data["banner_group"]      = $this->input->post("rdo_banner_group");
            $data["banner_columns"]    = $this->input->post("rdo_banner_columns");
            $data["banner_order"]      = $this->input->post("txt_banner_sort_order");
            if ($_FILES["img_banner"]["error"] == 0) {
                $newname = $_FILES["img_banner"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/banner/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_banner");
                
                $data["banner_image"] = $newname;
                $this->smart_resize_image("files/admin/banner/" . $newname, 262, 200, true, "files/admin/banner/thumb/" . $newname, false, false);
            }
            
            if ($_FILES["img_background_banner"]["error"] == 0) {
                $newname = $_FILES["img_background_banner"]["name"];
                $newname = $this->generate_random_name($newname);
                
                $config["file_name"]     = $newname;
                $config["upload_path"]   = "files/admin/banner/";
                $config["allowed_types"] = "gif|jpg|png|bmp|jpeg|ico|jpeg";
                $config["max_width"]     = "102400";
                $config["max_height"]    = "76800";
                $config["max_size"]      = 1024 * 1024 * 2;
                
                $this->load->library("upload");
                $this->upload->initialize($config);
                $this->upload->do_upload("img_background_banner");
                
                $data["banner_background_image"] = $newname;
                $this->smart_resize_image("files/admin/banner/" . $newname, 262, 200, true, "files/admin/banner/thumb/" . $newname, false, false);
            }
            $data["banner_background_color"] = $this->input->post("txt_background_color");
            $this->db->where("banner_id", $param3);
            $this->db->update("tbl_banner", $data);
            redirect(base_url() . "admin/manage_banner");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_banner", array(
                "banner_id" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("banner_id", $param2);
            $this->db->delete("tbl_banner");
            redirect(base_url() . "admin/manage_banner");
        }
        
        /* paging starts here */
        $per_page = $_SESSION["per_page"];
        
        
        if ($param1 == "search" && trim($this->input->post("txt_search")) != "") {
            $search = trim($this->input->post("txt_search"));
            $search = htmlspecialchars($search);
            $this->db->like("banner_title", $search, "after");
            
            $page_data["resultset"]   = $this->db->get("tbl_banner");
            $resultset                = $this->db->get("tbl_banner");
            $total_rows               = $resultset->num_rows();
            $page_data["search_data"] = $search;
        } else {
            $this->db->limit($per_page, $param1);
            
            $page_data["resultset"]     = $this->db->get("tbl_banner");
            $resultset                  = $this->db->get("tbl_banner");
            $total_rows                 = $resultset->num_rows();
            $page_data["search_data"]   = "";
            $page_data["paging_string"] = $this->paging_init("manage_banner", $total_rows, $per_page);
        }
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "Banner View";
        $page_data["page_name"]      = "banner_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    public function manage_settings($param1 = "", $param2 = "")
    {
        if ($param1 == "edit" && $param2 == "do_update") {
            $data['settings_website_title'] = $this->input->post('txt_title');
            $data['settings_meta_keywords'] = $this->input->post('txt_keyword');
            $data['settings_meta_desc']     = $this->input->post('txt_desc');
            $data['settings_website_name']  = $this->input->post('txt_name');
            $data['settings_show_badges']   = $this->input->post('chk_show_badges');
            
            if ($_FILES["img_logo"]["error"] == 0) {
                $newname = $_FILES["img_logo"]["name"];
                $newname = $this->generate_random_name($newname);
                
                //$newname=rand(100000,10000000)."_".$_FILES["img_logo"]["name"];
                //$config['file_name']='logonew.png';
                $config["file_name"]     = $newname;
                $config['upload_path']   = 'files/admin/logo/';
                //$confing['upload_path']='./template/user/img/';
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|ico';
                $config['max_width']     = '102400';
                $config['max_height']    = '76800';
                $config['max_size']      = 1024 * 1024 * 2;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('img_logo');
                $data['settings_logo'] = $newname;
                
                //$data['settings_logo']='logonew.png';
                
                $this->smart_resize_image("files/admin/logo/" . $newname, 262, 200, true, "files/admin/logo/" . $newname, false, false);
                
                
            }
            
            if ($_FILES["img_logo_small"]["error"] == 0) {
                
                $newname_small = $_FILES["img_logo_small"]["name"];
                $newname_small = $this->generate_random_name($newname_small);
                
                //$newname_small=rand(100000,10000000)."_".$_FILES["img_logo_small"]["name"];
                $config['file_name']     = $newname_small;
                $config['upload_path']   = 'files/admin/logo/';
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|ico';
                $config['max_width']     = '102400';
                $config['max_height']    = '76800';
                $config['max_size']      = 1024 * 1024 * 2;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('img_logo_small');
                $data['settings_small_logo'] = $newname_small;
            }
            
            if ($_FILES["img_logo_footer"]["error"] == 0) {
                $newname_footer = $_FILES["img_logo_footer"]["name"];
                $newname_footer = $this->generate_random_name($newname_footer);
                
                //$newname_footer=rand(100000,10000000)."_".$_FILES["img_logo_footer"]["name"];
                $config['file_name']     = $newname_footer;
                $config['upload_path']   = 'files/admin/logo/';
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|ico';
                $config['max_width']     = '102400';
                $config['max_height']    = '76800';
                $config['max_size']      = 1024 * 1024 * 2;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('img_logo_footer');
                $data['settings_footer_logo'] = $newname_small;
            }
            
            if ($_FILES["img_favicon"]["error"] == 0) {
                $newname_favicon = $_FILES["img_favicon"]["name"];
                $newname_favicon = $this->generate_random_name($newname_favicon);
                
                //$newname_favicon=rand(100000,10000000)."_".$_FILES["img_favicon"]["name"];
                $config['file_name']     = $newname_favicon;
                $config['upload_path']   = 'files/admin/logo/';
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|ico';
                $config['max_width']     = '102400';
                $config['max_height']    = '76800';
                $config['max_size']      = 1024 * 1024 * 2;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('img_favicon');
                $data['settings_favicon'] = $newname_small;
            }
            
            
            $data['settings_currency_code']   = $this->input->post('txt_code');
            $data['settings_currency_symbol'] = $this->input->post('txt_symbol');
            $data['settings_address']         = $this->input->post('txt_addr');
            $data['settings_phone']           = $this->input->post('txt_phone');
            $data['settings_fax']             = $this->input->post('txt_fax');
            $data['settings_contact_email']   = $this->input->post('txt_email');
            $data['settings_map_address']     = $this->input->post('txt_map_addr');
            $data['settings_toll_free']       = $this->input->post('txt_toll_free');
            $data['facebook_url']             = $this->input->post('txt_fb_url');
            $data['google_plus_url']          = $this->input->post('txt_google_url');
            $data['twitter_url']              = $this->input->post('txt_twitter_url');
            $data['pinterest_url']            = $this->input->post('txt_linkedin_url');
            $data['instagram_url']            = $this->input->post('txt_instagram_url');
            
            $data['settings_single_min_qty'] = $this->input->post('txt_single_min_qty');
            $data['settings_total_min_qty '] = $this->input->post('txt_total_min_qty');
            //$data['unit_name']=$this->input->post('txt_unit');
            $this->db->update("tbl_settings", $data);
            
            
            
            redirect(base_url() . 'index.php/admin/manage_settings');
        } else if ($param1 == "edit") {
            $page_data['edit_profile'] = $this->db->get('tbl_settings');
        }
        
        $page_data['function_name'] = 'manage_settings';
        $page_data['page_name']     = 'settings_view';
        $page_data['page_title']    = 'Website Settings';
        $page_data['settings']      = $this->db->get("tbl_settings");
        $this->load->view('admin/index', $page_data);
    }
    
    public function manage_cms($param1 = "", $param2 = "", $param3 = "")
    {
        if ($param1 == "edit" && $param2 == "do_update") {
            $data["cms_about_us"]         = $this->input->post("txt_about_us");
            $data["cms_privacy_policy"]   = $this->input->post("txt_privacy_policy");
            $data["cms_copy_right"]       = $this->input->post("txt_copy_right");
            $data["cms_trademark"]        = $this->input->post("txt_trademark");
            $data["cms_terms_conditions"] = $this->input->post("txt_terms_conditions");
            $data["cms_contact_us"]       = $this->input->post("txt_contact_us");
            $data["cms_bank_details"]     = $this->input->post("txt_bank_details");
            
            $this->db->update("tbl_cms", $data);
            redirect(base_url() . "admin/manage_cms");
        } else if ($param1 == "edit") {
            $page_data["edit_profile"] = $this->db->get_where("tbl_cms", array(
                "" => $param2
            ));
        }
        if ($param1 == "delete") {
            $this->db->where("", $param2);
            $this->db->delete("tbl_cms");
            redirect(base_url() . "admin/manage_cms");
        }
        
        /* paging starts here */
        $per_page = "10";
        $this->db->limit($per_page, $param1);
        
        $page_data["resultset"] = $this->db->get("tbl_cms");
        
        $resultset                  = $this->db->get("tbl_cms");
        $total_rows                 = $resultset->num_rows();
        $page_data["paging_string"] = $this->paging_init("manage_cms", $total_rows, $per_page);
        
        
        $page_data["start_position"] = intval($param1) + 1;
        $page_data["page_title"]     = "CMS View";
        $page_data["page_name"]      = "cms_view";
        
        $this->load->view("admin/index", $page_data);
    }
    
    
    
    //common functions starts here
    
    public function paging_init($controller_name, $total_row, $per_page)
    {
        /* pagination class starts here */
        //echo $controller_name;
        $this->load->library('pagination');
        $config['base_url']   = base_url() . 'admin/' . $controller_name;
        $config['total_rows'] = $total_row;
        $config['per_page']   = $per_page;
        
        // this extra 
        //$config['uri_segment'] = 4;
        //$config['use_page_numbers'] = TRUE;
        //$config['page_query_string'] = TRUE;
        // this extra ends here
        
        $config['first_tag_open']  = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['cur_tag_open']    = "<li class='active'><span>";
        $config['cur_tag_close']   = "</span></li>";
        
        $this->pagination->initialize($config);
        $paging_string = $this->pagination->create_links();
        return $paging_string;
        /* pagination class ends here */
    }
    
    public function generate_random_name($filename)
    {
        $ext         = pathinfo($filename, PATHINFO_EXTENSION);
        //echo $ext;
        //$newfilename = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . "_" . substr(str_shuffle('aBcEeFgHiJkLmNoPqRstUvWxYz0123456789'), 0, 5) . "_" . rand(1000000, 100000000) .  "_".str_replace(" ", "", $filename)."." . $ext;
        $newfilename = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . "_" . substr(str_shuffle('aBcEeFgHiJkLmNoPqRstUvWxYz0123456789'), 0, 5) . "_" . rand(1000000, 100000000) . "_" . str_replace(" ", "", $filename);
        return $newfilename;
    }
    
    public function smart_resize_image($file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false)
    {
        if ($height <= 0 && $width <= 0) {
            return false;
        }
        
        $info  = getimagesize($file);
        $image = '';
        
        $final_width  = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;
        
        if ($proportional) {
            if ($width == 0)
                $factor = $height / $height_old;
            elseif ($height == 0)
                $factor = $width / $width_old;
            else
                $factor = min($width / $width_old, $height / $height_old);
            
            $final_width  = round($width_old * $factor);
            $final_height = round($height_old * $factor);
            
        } else {
            $final_width  = ($width <= 0) ? $width_old : $width;
            $final_height = ($height <= 0) ? $height_old : $height;
        }
        
        switch ($info[2]) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
                break;
            default:
                return false;
        }
        
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $trnprt_indx = imagecolortransparent($image);
            
            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {
                
                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
                
                // Allocate the same color in the new image resource
                $trnprt_indx = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                
                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $trnprt_indx);
                
                // Set the background color for new image to transparent
                imagecolortransparent($image_resized, $trnprt_indx);
                
                
            }
            // Always make a transparent background color for PNGs that don't have one allocated already
            elseif ($info[2] == IMAGETYPE_PNG) {
                
                // Turn off transparency blending (temporarily)
                imagealphablending($image_resized, false);
                
                // Create a new transparent color for image
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                
                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $color);
                
                // Restore transparency blending
                imagesavealpha($image_resized, true);
            }
        }
        
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
        
        if ($delete_original) {
            if ($use_linux_commands)
                exec('rm ' . $file);
            else
                @unlink($file);
        }
        
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }
        
        switch ($info[2]) {
            case IMAGETYPE_GIF:
                imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image_resized, $output);
                break;
            case IMAGETYPE_PNG:
                imagepng($image_resized, $output);
                break;
            default:
                return false;
        }
        
        return true;
    }
    
    public function manage_unzip()
    {
        $data['volume_id']       = $this->input->post('txt_volume_id');
        $newname                 = $_FILES["zip_file"]["name"];
        $newname                 = $this->generate_random_name($newname);
        $config['file_name']     = $newname;
        $config['upload_path']   = 'files/admin/product_zip/';
        $config['allowed_types'] = 'zip';
        $config['max_width']     = '102400';
        $config['max_height']    = '76800';
        $config['max_size']      = 1024 * 1024 * 20;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload('zip_file');
        
        $zip = new ZipArchive;
        $res = $zip->open('files/admin/product_zip/' . $newname);
        if ($res === TRUE) {
            $zip->extractTo('files/admin/product/');
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $oldname = $zip->getNameIndex($i);
                $newname = rand(10000, 1000000) . "_" . str_replace(" ", "_", $zip->getNameIndex($i));
                rename('files/admin/product/' . $oldname, 'files/admin/product/' . $newname);
                $this->smart_resize_image("files/admin/product/" . $newname, 262, 200, true, "files/admin/product/thumb/" . $newname, false, false);
                $this->smart_resize_image("files/admin/product/" . $newname, 600, 615, true, "files/admin/product/med/" . $newname, false, false);
                $data['volume_product_image']  = $newname;
                $data['volume_product_status'] = 'Active';
                $this->db->insert('tbl_volume_product', $data);
            }
            $zip->close();
            $page_data['category_msg'] = '<h2 style="color:green">Catalogue Product Images Uploaded Successfully</h2>';
        } else {
            $page_data['category_msg'] = '<h2 style="color:red">There is problem while uploading</h2>';
        }
        
        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
    }
    
    public function readxls($file)
    {
        $this->load->library('excel');
        //read file from path
        $objPHPExcel     = PHPExcel_IOFactory::load($file);
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        //extract to a PHP readable array format
        foreach ($cell_collection as $cell) {
            $column     = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row        = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            //header will/should be in row 1 only. of course this can be modified to suit your need.
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }
        //send the data in an array format
        $data['header'] = $header;
        $data['values'] = $arr_data;
        
        return $data;
        
        /*      echo "<table>";
        foreach($data['header'][1] as $key => $value){
        echo "<th>".$value."</th>";
        }
        
        foreach($data['values'] as $datakey=>$datavalue)
        {
        echo "<tr>";
        foreach($datavalue as $key=>$value)
        {
        echo "<td>".$value."</td>";
        }
        echo "</tr>";
        }
        echo "</table>";
        */
    }
    
    //common functions ends here
}
?>
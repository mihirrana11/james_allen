
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Front Menu</h4>
        </div>
        <div class="modal-body">
            <!-- Add Modal Form -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <form role="form" method="post" action="<?php echo base_url(); ?>admin/manage_front_menu/create" enctype="multipart/form-data">
                                <div class="box-body">
                                        <div class="form-group">
                                                    <label>Menu Title</label>
                                                    <input class="form-control" id="txt_front_menu" name="txt_front_menu">
                                        </div>
                                        <div class="form-group">
                                                    <label>URL</label>
                                                    <input class="form-control" id="txt_front_menu_url" name="txt_front_menu_url">
                                        </div>
                                        <div class="form-group">
                                                    <label>FA - ICON</label>
                                                    <input class="form-control" id="txt_front_menu_icon" name="txt_front_menu_icon">
                                        </div>
                                        <div class="form-group">
                                                    <label>Banner Image</label>
                                                    <input type="file" id="txt_front_menu_icon_image" name="txt_front_menu_icon_image">
                                        </div>
                                        <div class="form-group">
                                                    <label>Sort Order</label>
                                                    <input class="form-control" id="txt_front_menu_sort_order" name="txt_front_menu_sort_order">
                                        </div>
                                        <div class="form-group">
                                                    <label>Visible Start Date</label>
                                                    <div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input type="text" class="form-control pull-right" id="txt_front_menu_start_date" name="txt_front_menu_start_date" >
                                                    </div>
                                        </div>
                                        <div class="form-group">
                                                    <label>Visible End Date</label>
                                                    <div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input type="text" class="form-control pull-right" id="txt_front_menu_end_date" name="txt_front_menu_end_date" >
                                                    </div>
                                        </div>
                                        <div class="form-group">
                                                    <label>Left Side Image</label>
                                                    <input type="file" id="img_front_menu_left_side_image" name="img_front_menu_left_side_image">
                                        </div>
                                        <div class="form-group">
                                                    <label>Right Side Image</label>
                                                    <input type="file" id="img_front_menu_right_side_image" name="img_front_menu_right_side_image">
                                        </div>
                                        <div class="form-group">
                                                    <label>Text on Image</label>
                                                    <input class="form-control" id="txt_front_menu_text_on_image" name="txt_front_menu_text_on_image">
                                        </div>
                                        <div class="form-group">
                                                    <label>Front Menu Label</label>
                                                    <select class="form-control"  id="cmb_front_menu_label_id" name="cmb_front_menu_label_id">
                                                    <option value="0">--None--</option>
                                                    <?php 
                                                    $select_res    = $this->db->get("tbl_front_menu_label");
                                                    foreach($select_res->result() as $select_row)
                                                    {
                                                        echo "<option value=".$select_row->front_menu_label_id.">".$select_row->front_menu_label."</option>";
                                                    }
                                                    ?>
                                                    </select>
                                        </div>
                                        <div class="form-group">
                                                    <label>Status</label>
                                                    <?php 
                                                    $radio_array=array("Active","In-Active");
                                                    for($i=0;$i<count($radio_array);$i++)
                                                    {
                                                        ?>
                                                        <input type="radio" id="rdo_front_menu_status" name="rdo_front_menu_status" value="<?php echo $radio_array[$i]; ?>"><?php echo $radio_array[$i]; ?>
                                                        <?php
                                                    }
                                                    ?>
                                        </div>
                                        <input type="hidden" class="form-control" id="txt_parent_id" name="txt_parent_id" value="<?php echo $parent_id; ?>">
                                        
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                </div>
                            </form>
                        </div></div>
                    
                </div>
            <!-- Add Modal Form Ends -->
        </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>

<div class="content-wrapper">
    
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
                  <!--<h3 class="box-title" style="font-size:25px">Front Menu List</h3>
                <label style="float:right">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add New Front Menu</button>
                </label>-->


                <div class="row">
                    <div class="col-md-6">
                        <h3 class="box-title" style="font-size:25px">Front Menu List</h3>
                    </div><div class="col-md-3">
                        <form id="search_form" name="search_form" method="post" action="<?php echo base_url()."admin/manage_front_menu/search/"; ?>">
                                        <div class="form-group" style="float:right">
                                                <!--<label>Search: -->
                                                    <input class="form-control" type="text" id="txt_search" name="txt_search" placeholder="Search front menu title"  onKeyDown="submit_form(event);"
                                                value="<?php if(isset($search_data))
                                                {echo $search_data; }?>">
                                                <!--</label>-->
                                        </div>
                        </form>
                        <script type="text/javascript">
                            function submit_form(event)
                            {
                                //alert(event.keyCode);
                                if (event.keyCode == 13) 
                                {
                                    //window.location="http://www.google.com";
                                    document.getElementById("search_form").submit();
                                }
                            }
                        </script>
                    </div>
                    <div class="col-md-3">
                        <label style="float:right">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add New Front Menu</button>
                        </label>
                    </div>
                        
                </div>
            </div>


            <div class="box-body table-responsive no-padding">
            
                <table class="table table-bordered table-hover">
                              <thead>
                                  <th>#</th>
                                <th>Menu Title</th>
                                <th>URL</th>
                                <th>FA - ICON</th>
                                <th>Banner Image</th>
                                <th>Sort Order</th>
                                <th>Visible Start Date</th>
                                <th>Visible End Date</th>
                                <th>Left Side Image</th>
                                <th>Right Side Image</th>
                                <th>Text on Image</th>
                                <!--<th>Front Menu Label</th>-->
                                <th>Status</th>
                                <!--<th>Parent Id</th>-->
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php
                            $i=1;
                            foreach($resultset->result() as $result_row)
                            {
                            ?>
                                <tr>
                                <td><?php echo $i; ?></td>
                                    <td><a href='<?php echo base_url(); ?>admin/manage_front_menu/<?php echo $result_row->front_menu_id; ?>'><?php echo $result_row->front_menu_title; ?></a></td>
                                    <td><?php echo $result_row->front_menu_url; ?></td>
                                    <td><?php echo $result_row->front_menu_icon; ?></td>
                                    <td>
                                    <?php 
                                        if(trim($result_row->front_menu_icon_image)!="")
                                        {
                                        ?>
                                    <img src="<?php echo base_url(); ?>files/admin/front_menu/thumb/<?php echo $result_row->front_menu_icon_image; ?>" width="40px">
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $result_row->front_menu_sort_order; ?></td>
                                    <td><?php echo $result_row->front_menu_visible_start_date; ?></td>
                                    <td><?php echo $result_row->front_menu_visible_end_date; ?></td>
                                    <td>
                                    <?php 
                                        if(trim($result_row->front_menu_left_side_image)!="")
                                        {
                                        ?>
                                    <img src="<?php echo base_url(); ?>files/admin/front_menu/thumb/<?php echo $result_row->front_menu_left_side_image; ?>" width="40px">
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if(trim($result_row->front_menu_right_side_image)!="")
                                        {
                                        ?>
                                    <img src="<?php echo base_url(); ?>files/admin/front_menu/thumb/<?php echo $result_row->front_menu_right_side_image; ?>" width="40px">
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $result_row->front_menu_text_on_image; ?></td>
                                    <!--<td><?php //echo $result_row->front_menu_label; ?></td>-->
                                    <td><?php echo $result_row->front_menu_status; ?></td>
                                    <!--<td><?php //echo $result_row->parent_id; ?></td>-->
                                    <td>
                                        <a class="btn btn-success" class="btn btn-info" data-toggle="modal" data-target="#editModal" onclick="get_edit_data(<?php echo $result_row->front_menu_id; ?>);"><em class="fa fa-pencil"></em></a>
                                        <a class="btn btn-danger confirm-delete" data-id="<?php echo $result_row->front_menu_id; ?>"><em class="fa fa-trash-o"></em></a>
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                } 
                                ?>
                            </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php 
                    if(isset($paging_string))
                    {
                        echo $paging_string; 
                    }
                ?>
              </ul>
            </div>
          </div>
           </div>
      </div>
    </section>
<!-- /.container-fluid -->
</div>
<script type="text/javascript">
function confirmDelete()
{
  return confirm("Are you sure you want to delete this?");
}
</script>
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Front Menu</h4>
        </div>
        <div class="modal-body">
            <!-- Edit Modal Form -->
                <div class="row">
                    <div class="col-lg-12" id="edit_div">
                    </div>
                </div>
            <!-- Edit Modal Form Ends -->
        </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>
<script type="text/javascript">
            var controller = "ajax/get_front_menu";
            var base_url = "<?php echo base_url(); ?>";

     function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp=false;  
        try{
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)    {       
            try{            
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e){
                try{
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e){
                    xmlhttp=false;
                }
            }
        }
            
        return xmlhttp;
    }

    function get_edit_data(primary_id)
    {       
        var strURL=base_url+controller+"/"+primary_id;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                    //alert(req.responseText);                      
                        document.getElementById("edit_div").innerHTML=req.responseText;
                        
                            $('#txt_front_menu_start_date_2').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true
                            })
                            $('#txt_front_menu_end_date_2').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true
                            })
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }               
            }           
            req.open("GET", strURL, true);
            req.send(null);
            
        }
    }

    
</script>
<div id="deleteModal"  class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close">X</a>
                 <h3>Delete Front Menu</h3>
            </div>
                <div class="modal-body">
                    <p>You are about to delete.</p>
                    <p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                        <a href="#" id="btnYes" class="btn btn-sm btn-danger">Yes</a>
                        <a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-success">No</a>
                    
                </div>
            
        </div>
    </div>
</div>
<script>
$('#deleteModal').on('show', function() {
    var id = $(this).data('id'),
        removeBtn = $(this).find('.danger');
})

$('.confirm-delete').on('click', function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    $('#deleteModal').data('id', id).modal('show');
});

$('#btnYes').click(function() {
    // handle deletion here
    var id = $('#deleteModal').data('id');
    //$('[data-id='+id+']').remove();
    window.location=base_url+'admin/manage_front_menu/delete/'+id;
    $('#deleteModal').modal('hide');
});
</script>
<script src='<?php echo base_url(); ?>template/ckeditor/ckeditor.js'></script>
<script>
  $(function () {
      
                                            $('#txt_front_menu_start_date').datepicker({
                                              format: 'yyyy-mm-dd',
                                              autoclose: true
                                            })
                                            $('#txt_front_menu_end_date').datepicker({
                                              format: 'yyyy-mm-dd',
                                              autoclose: true
                                            })
      })
</script>



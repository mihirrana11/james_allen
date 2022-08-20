<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Block</h4>
        </div>
        <div class="modal-body">
            <!-- Add Modal Form -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <form role="form" method="post" action="<?php echo base_url(); ?>admin/manage_block/create" enctype="multipart/form-data">
                                <div class="box-body">
                                        <div class="form-group">
                                                    <label>Title</label>
                                                    <input class="form-control" id="txt_block_title" name="txt_block_title">
                                        </div>
                                        <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" id="txt_block_desc" name="txt_block_desc" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                                    <label>Block Group</label>
                                                    <?php 
                                                    $radio_array=array('Best Deals','Bottom','Place One','Place Two','Place Three','Sidebar');
                                                    for($i=0;$i<count($radio_array);$i++)
                                                    {
                                                        ?>
                                                        <input type="radio" id="rdo_block_group" name="rdo_block_group" value="<?php echo $radio_array[$i]; ?>"><?php echo $radio_array[$i]; ?>
                                                        <?php
                                                    }
                                                    ?>
                                        </div>
                                        <div class="form-group">
                                                    <label>Columns</label>
                                                    <?php 
                                                    $radio_array=array('4','6','8','12');
                                                    for($i=0;$i<count($radio_array);$i++)
                                                    {
                                                        ?>
                                                        <input type="radio" id="rdo_block_columns" name="rdo_block_columns" value="<?php echo $radio_array[$i]; ?>"><?php echo $radio_array[$i]; ?>
                                                        <?php
                                                    }
                                                    ?>
                                        </div>
                                        <div class="form-group">
                                                    <label>Sort Order</label>
                                                    <input class="form-control" id="txt_block_order" name="txt_block_order">
                                        </div>
                                        <div class="form-group">
                                                    <label>Block Image</label>
                                                    <input type="file" id="img_block" name="img_block">
                                        </div>
                                        <div class="form-group">
                                                    <label>Background Image</label>
                                                    <input type="file" id="img_block_background" name="img_block_background">
                                        </div>
                                        <div class="form-group">
                                                    <label>Background Color</label>
                                                    <div class="input-group my-colorpicker2">
                                                      <input type="text"  id="txt_block_background_color" name="txt_block_background_color" class="form-control">
                                                      <div class="input-group-addon">
                                                        <i></i>
                                                      </div>
                                                    </div>
                                        </div>
                                        <div class="form-group">
                                                    <label>Status</label>
                                                    <?php 
                                                    $radio_array=array("Active","In-Active");
                                                    for($i=0;$i<count($radio_array);$i++)
                                                    {
                                                        ?>
                                                        <input type="radio" id="rdo_block_status" name="rdo_block_status" value="<?php echo $radio_array[$i]; ?>"><?php echo $radio_array[$i]; ?>
                                                        <?php
                                                    }
                                                    ?>
                                        </div>
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
                  <!--<h3 class="box-title" style="font-size:25px">Block List</h3>
                <label style="float:right">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add New Block</button>
                </label>-->


                <div class="row">
                    <div class="col-md-6">
                        <h3 class="box-title" style="font-size:25px">Block List</h3>
                    </div><div class="col-md-3">
                        <form id="search_form" name="search_form" method="post" action="<?php echo base_url()."admin/manage_block/search/"; ?>">
                                        <div class="form-group" style="float:right">
                                                <!--<label>Search: -->
                                                    <input class="form-control" type="text" id="txt_search" name="txt_search" placeholder="Search block title"  onKeyDown="submit_form(event);"
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
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add New Block</button>
                        </label>
                    </div>
                        
                </div>
            </div>


            <div class="box-body table-responsive no-padding">
            
                <table class="table table-bordered table-hover">
                              <thead>
                                  <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Block Group</th>
                                <th>Columns</th>
                                <th>Sort Order</th>
                                <th>Block Image</th>
                                <th>Background Image</th>
                                <th>Background Color</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php
                            if(!isset($start_position))
                            {
                                $i=1;
                            }
                            else
                            {
                                $i=$start_position;
                            }
                            foreach($resultset->result() as $result_row)
                            {
                            ?>
                                <tr>
                                <td><?php echo $i; ?></td>
                                    <td><?php echo $result_row->block_title; ?></td>
                                    <td><?php echo $result_row->block_desc; ?></td>
                                    <td><?php echo $result_row->block_group; ?></td>
                                    <td><?php echo $result_row->block_columns; ?></td>
                                    <td><?php echo $result_row->block_order; ?></td>
                                    <td>
                                    <?php 
                                        if(trim($result_row->block_image)!="")
                                        {
                                        ?>
                                    <img src="<?php echo base_url(); ?>files/admin/block/thumb/<?php echo $result_row->block_image; ?>" width="40px">
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if(trim($result_row->block_background_image)!="")
                                        {
                                        ?>
                                    <img src="<?php echo base_url(); ?>files/admin/block/thumb/<?php echo $result_row->block_background_image; ?>" width="40px">
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $result_row->block_background_color; ?></td>
                                    <td><?php echo $result_row->block_status; ?></td>
                                    <td>
                                        <a class="btn btn-success" class="btn btn-info" data-toggle="modal" data-target="#editModal" onclick="get_edit_data(<?php echo $result_row->block_id; ?>);"><em class="fa fa-pencil"></em></a>
                                        <a class="btn btn-danger confirm-delete" data-id="<?php echo $result_row->block_id; ?>"><em class="fa fa-trash-o"></em></a>
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
            <h4 class="modal-title">Edit Block</h4>
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
            var controller = "ajax/get_block";
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
                        
                            CKEDITOR.replace( "txt_block_desc2", {
                                fullPage: true,
                                allowedContent: true,
                                extraPlugins: "wysiwygarea"
                                 
                                });
                            
                            $('.my-colorpicker2').colorpicker()
                            
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
    <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close">X</a>
                 <h3>Delete Block</h3>
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
    window.location=base_url+'admin/manage_block/delete/'+id;
    $('#deleteModal').modal('hide');
});
</script>
<script src='<?php echo base_url(); ?>template/ckeditor/ckeditor.js'></script>
<script>
  $(function () {
      
                                            CKEDITOR.replace( "txt_block_desc", {
                                                fullPage: true,
                                                allowedContent: true,
                                                extraPlugins: "wysiwygarea"
                                                 
                                                });
                                            
                                            $('.my-colorpicker2').colorpicker()
                                            
      })
</script>



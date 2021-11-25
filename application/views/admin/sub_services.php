<style>
    #sub_service_details{
        display:none;
    }
</style>
<?php if ($row->service_id == '7'){ ?>
    <style>
        #sub_service_details{
            display:block;
        }
    </style>
<?php } ?>   
<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update services')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Services</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/sub_services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmGuide Categoreis" role="form" class="form-horizontal blog-form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Display Options</div>
                            <div class="panel-body" style="padding: 15.5px 0px">
                                <div class="col-md-3">
                                    <h5>Status</h5>
                                </div>
                                <div class="col-md-7">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on btn-sm <?php if($row->status == 1){echo 'active';}?>">
                                        <input type="radio" value="1" name="status"<?php if($row->status == 1){echo 'checked';}?>><i class="fa fa-check" aria-hidden="true"></i></label>
                                        
                                        <label class="btn btn-default btn-off btn-sm <?php if($row->status == 0){echo 'active';}?>">
                                        <input type="radio" value="0" name="status" <?php if($row->status == 0){echo 'checked';}?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>  
                    
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="service_id"> Service</label>
                        <select id="service_id" name="service_id" class="form-control" required onchange="serviceChanged(this.value)">
                            <option value=""  selected>----Select----</option>
                            <?= $services = get_services()?>
                            <?php foreach($services as $service){ ?>
                                <option value="<?=$service->id?>"<?= (isset($service->name) && $row->service_id == $service->id ? ' selected' : '')?>><?=$service->name?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="name"> Name</label>
                        <input type="text" name="name" id="name" value="<?php if (isset($row->name)) echo $row->name; ?>" class="form-control" autofocus required>
                    </div>
                </div> 
                <div class="form-group" id="sub_service_details">
                    <div class="col-md-12">
                        <label class="control-label" for="description">Details</label>
                        <textarea type="text" name="details" id="details" rows="2" class="form-control"><?php if (isset($row->details)) echo $row->details; ?></textarea>
                    </div>
                </div> 
              <hr>			
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Sub Services')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Sub services</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/sub_services/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <form method="post" action="<?=base_url('admin/sub_services/deleteAll')?>">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <!-- <th width="" class="text-center no_order" style="">
                    <button type="submit" onclick="return confirm('Are you sure to delete?');" name="delete_selected" class="btn btn-sm btn-danger">Delete</button>
                </th> -->
                <th width="5%" class="text-center">Sr#</th>
                <th>Service</th>
                <th>Title</th>
                <th>Added Date</th>
                <th>Deleted Date</th>
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <!-- <td class="text-center">
                            <input type="checkbox" name="checkbox_id[]" class="select_checkbox" value="<?= $row->id ?>">
                        </td> -->
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><?= get_service_name($row->service_id); ?></b></td>
                        <td><b><?= $row->name; ?></b></td>
                        <td><b><?= $row->added_date?></b></td>
                        <td><b>
                            <?php if($row->status == '1'){
                                echo '-';
                            }else{
                            echo $row->deleted_date ;
                            } ?>
                        </b></td>
                        <td><?=get_active_status($row->status)?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" style="left:inherit;right:0;" role="menu">
                                    <li><a href="<?= site_url(ADMIN.'/sub_services/manage/'.$row->id); ?>">Edit</a></li>
                                    <!-- <li><a href="<?= site_url(ADMIN.'/sub_services/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li> -->
                                    <li>
                                        <a href="<?= site_url(ADMIN.'/sub_services/changestatus/'.$row->id); ?>" onclick="return confirm('Do you want to change status?');">
                                            <?php if($row->status == '1'){
                                                echo 'Inactive';
                                            }else{
                                            echo 'Active' ;
                                            } ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
<script>
    var service_id;
    function serviceChanged(service_id){
        if(service_id == '7'){
            document.getElementById('sub_service_details').style.display='block';
        }else{
            document.getElementById('sub_service_details').style.display='none';
        }
    }
</script>

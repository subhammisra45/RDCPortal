<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to employees.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);
    //Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');
    $db = getDbInstance();
    $last_id = $db->insert ('employees', $data_to_store);
    
    if($last_id)
    {
    	$_SESSION['success'] = "employee added successfully!";
    	header('location: employees.php');
    	exit();
    }  
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Employees</h2>
        </div>
        
</div>
    <form class="form" action="" method="post"  id="employee_form" enctype="multipart/form-data">
       <?php  include_once('./forms/employee_form.php'); ?>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#employee_form").validate({
       rule: {
            FullName: {
                required: true,
                minlength: 4
            } 
        }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>
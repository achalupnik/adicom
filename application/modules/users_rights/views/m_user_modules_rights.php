<style>
    .bg-blue {
        background-color: aliceblue;
    }
    .bg-blue:not(:first-of-type) {
        margin-top: 15px;

    }
    .bg-blue h4 {
        line-height: 170%;
    }
    .width-half {
        width: 50%;
        float: left;
        background-color: white;
    }
    .l_input_changed {
        color: coral !important;
    }
</style>


<?php foreach($all_modules_rights['module_id'] as $key_module_id => $module): ?>
    <div class="bg-blue">
        <h4 class="text-center">
            <?=$module['module_desc'];?>
        </h4>
    </div>
    <?php foreach($module['right_id'] as $key_right_id => $right_name): ?>
        <div class="width-half">
            <input type="checkbox" id='<?=$key_module_id;?>_<?=$key_right_id;?>' class="i_ch_right" <?=(isset($user_modules_rights['module_id'][$key_module_id]['right_id'][$key_right_id])&&$user_modules_rights['module_id'][$key_module_id]['right_id'][$key_right_id]==1)?'checked':'' ?>>
            <label class="noselect" for="<?=$key_module_id;?>_<?=$key_right_id;?>">
                <?=$right_name;?> 
            </label>
            <?php if(isset($user_groups_rights['module_id'][$key_module_id]['right_id'][$key_right_id])): ?>
                <span class="badge badge-info" data-toggle="tooltip" title="<?="Liczba grup do których należy użytkownik, które rónież dają mu to uprawnienie \n (".$user_groups_rights['module_id'][$key_module_id]['right_id'][$key_right_id]['groups_names'].")";?>">[<?=$user_groups_rights['module_id'][$key_module_id]['right_id'][$key_right_id]['number_groups'];?>]</span>
            <?php endif;?>
        </div>
    <?php endforeach; ?>
    <div style="clear:both"></div>
<?php endforeach; ?>


<script>
    var checked_inputs = [], unchecked_inputs = [];
    createInuptsList();
    
    function createInuptsList() {
        $('input[type="checkbox"]').each(function(index) {
            if(this.checked) {
                checked_inputs[checked_inputs.length] = $(this).attr('id');
            } else {
                unchecked_inputs[unchecked_inputs.length] = $(this).attr('id');
            }
        })
    }

    $('.i_ch_right').change(function() {
        if($(this).next().hasClass('l_input_changed')) 
            $(this).next().removeClass('l_input_changed')
        else 
            $(this).next().addClass('l_input_changed');
    })

    
    



</script>
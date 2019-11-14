    $(document).on('click','.category-name-container',function(e){
        console.log(e.target.className)
        if (e.target.className=="category-name-container" || e.target.className=="category-name") {
            if ($(this).closest('.level-1-menu-li').find('.level-2-menu').is(':visible')) {
                $(this).closest('.level-1-menu-li').find('.level-2-menu').hide();
                $(this).find('.subgroup_hide_show i').removeClass('fa-minus-circle');
            }else{
                 $(this).closest('.level-1-menu-li').find('.level-2-menu').show();
                 $(this).find('.subgroup_hide_show i').addClass('fa-minus-circle');
            }
        }       
        
    });
    $(document).on('click','.subgroup-strip',function(e){
        console.log(e)
        
        $class = e.target.className.split(' ');console.log($class);
        if ($class[0]=="subgroup-strip" || $class[0]=="subgroup-name") {
            if ($(this).closest('.level-2-menu-li').find('.level-3-menu').is(':visible')) {
                $(this).closest('.level-2-menu-li').find('.level-3-menu').hide();
                $(this).find('.recipe_hide_show i').removeClass('fa-minus-circle');
            }else{
                $(this).closest('.level-2-menu-li').find('.level-3-menu').show();
                $(this).find('.recipe_hide_show i').addClass('fa-minus-circle');
            }
        }       
        
    });
    $(document).on('click','.subgroup_hide_show',function(){
        $obj = $(this);
        
        $(this).toggleClass('opened');
        $(this).find('i').toggleClass('fa-minus-circle');
        $(this).closest('li').find('.level-2-menu').toggle();
        if ($(this).closest('li').find('.level-2-menu').is(':visible')) {
            $('.subgroup_hide_show.opened').not(this).closest('li').find('.level-2-menu').hide();
            $('.subgroup_hide_show.opened').not(this).find('i').removeClass('fa-minus-circle');
        }
       
        
    });
    $(document).on('click','.recipe_hide_show',function(){
        $obj = $(this);
         $(this).find('i').toggleClass('fa-minus-circle');
        $(this).closest('li.level-2-menu-li').find('.level-3-menu').toggle();
    });
    $(document).on('ifChanged','.icheckbox_square-blue input.recipe-group', function (e) {
        $obj = $(this);
        console.log($obj)
        var isChecked = e.currentTarget.checked;
                            
        if (isChecked == true) {
            if (!$obj.closest('.level-1-menu-li').find('.level-2-menu').is(':visible')) {
                $obj.closest('.level-1-menu-li').find('.level-2-menu').show();
                $obj.closest('.level-1-menu-li').find('.subgroup_hide_show i').addClass('fa-minus-circle');
            }
            //$obj.closest('li').find('.recipe-subgroup,.recipe-brand').iCheck('check');
        }else{
            $all_r_len = $obj.closest('li').find('.recipe-subgroup').length;
            $c_r_len = $obj.closest('li').find('.recipe-subgroup:checked').length;
            if ($all_r_len==$c_r_len) {
               // $obj.closest('li').find('.recipe-subgroup,.recipe-brand').iCheck('uncheck');
            }
        }
    });
    $(document).on('ifChanged','.icheckbox_square-blue input.recipe-subgroup', function (e) {
        $obj = $(this);
        //console.log($obj)
        var isChecked = e.currentTarget.checked;
                            
        if (isChecked == true) {
            if (!$obj.closest('.level-2-menu-li').find('.level-3-menu').is(':visible')) {
                $obj.closest('.level-2-menu-li').find('.level-3-menu').show();
                $obj.closest('.level-2-menu-li').find('.recipe_hide_show i').addClass('fa-minus-circle');
            }
           
            //$obj.closest('li').find('.recipe-brand').iCheck('check');
        }else{
            $all_len = $obj.closest('li').find('.recipe-brand').length;
            $c_len = $obj.closest('li').find('.recipe-brand:checked').length;
            console.log('sub:'+$all_len+'=='+$c_len)
           
            $obj.closest('li').find('.recipe-brand').iCheck('uncheck');
            
            
        }
        
        $checkbox = $obj.closest('li.level-1-menu-li ul').find('.recipe-subgroup').length;
        
        $checked =false;
        $checked = $obj.closest('li.level-1-menu-li ul').find('.recipe-subgroup:checked').length;
        console.log('group:'+$checkbox+'=='+$checked)
        if ($checked!=0) {
            $obj.closest('li.level-1-menu-li').find('.recipe-group').iCheck('check');
        }else{
            $obj.closest('li.level-1-menu-li').find('.recipe-group').iCheck('uncheck');
        }        
    });
    $(document).on('ifChanged','.icheckbox_square-blue input.recipe-brand', function (e) {
        $obj = $(this);
        var isChecked = e.currentTarget.checked;
        
        $all = $obj.closest('li.level-2-menu-li').find('.level-3-menu input[type="checkbox"]').length;
        $checked = $obj.closest('li.level-2-menu-li').find('.level-3-menu input[type="checkbox"]:checked').length;
        console.log('length:'+$all+'=='+$checked)
        if (0!=$checked) {
            $obj.closest('li.level-2-menu-li').find('.recipe-subgroup').iCheck('check');
        }else{
            $obj.closest('li.level-2-menu-li').find('.recipe-subgroup').iCheck('uncheck');
        }  
    });
    $(document).ready(function(){    
        //$('.recipe-subgroup').each(function(){
        //    $obj = $(this);
        //    $checkbox = $obj.closest('li').find('.recipe-brand').length;
        //    $checked =false;
        //    $checked = $obj.closest('li').find('.recipe-brand:checked').length;
        //    //console.log('subgroup:'+$checkbox+'=='+$checked)
        //    if ($checkbox == $checked && $checkbox!=0) {
        //        $obj.closest('li.level-1-menu-li').find('.recipe-subgroup').iCheck('check');
        //    }else{
        //        $obj.closest('li.level-1-menu-li').find('.recipe-subgroup').iCheck('uncheck');
        //    }      
        //});
        //$('.recipe-group').each(function(){
        //    $obj = $(this);
        //    $checkbox = $obj.closest('li').find('.recipe-subgroup').length + $obj.closest('li').find('.recipe-brand').length;
        //    $checked =false;
        //    $checked = $obj.closest('li').find('.recipe-subgroup:checked').length + $obj.closest('li').find('.recipe-brand:checked').length;
        //    //console.log('group:'+$checkbox+'=='+$checked)
        //    if ($checkbox == $checked && $checkbox!=0) {
        //        $obj.closest('li.level-1-menu-li').find('.recipe-group').iCheck('check');
        //    }else{
        //        $obj.closest('li.level-1-menu-li').find('.recipe-group').iCheck('uncheck');
        //    }      
        //});
    });
$(function () {

    // ------------------------------------------------------- //
    // Tooltips init
    // ------------------------------------------------------ //    

    $('[data-toggle="tooltip"]').tooltip()        

    // ------------------------------------------------------- //
    // Universal Form Validation
    // ------------------------------------------------------ //

    $('.form-validate').each(function() {  
        $(this).validate({
            errorElement: "div",
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            ignore: ':hidden:not(.summernote),.note-editable.card-block',
            errorPlacement: function (error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                //console.log(element);
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.siblings("label"));
                } 
                else {
                    error.insertAfter(element);
                }
            }
        });
    });

    // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function() { return $(this).val() !== ""; }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

    // ------------------------------------------------------- //
    // Footer 
    // ------------------------------------------------------ //   

    var pageContent = $('.page-content');

    $(document).on('sidebarChanged', function () {
        adjustFooter();
    });

    $(window).on('resize', function(){
        adjustFooter();
    })

    function adjustFooter() {
        var footerBlockHeight = $('.footer__block').outerHeight();
        pageContent.css('padding-bottom', footerBlockHeight + 'px');
    }

    // ------------------------------------------------------- //
    // Adding fade effect to dropdowns
    // ------------------------------------------------------ //
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn(100).addClass('active');
    });
    $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut(100).removeClass('active');
    });


    // ------------------------------------------------------- //
    // Search Popup
    // ------------------------------------------------------ //
    $('.search-open').on('click', function (e) {
        e.preventDefault();
        $('.search-panel').fadeIn(100);
    })
    $('.search-panel .close-btn').on('click', function () {
        $('.search-panel').fadeOut(100);
    });


    // ------------------------------------------------------- //
    // Sidebar Functionality
    // ------------------------------------------------------ //

    $('.sidebar-toggle').on('click', function () {
        $(this).toggleClass('active');

        $('#sidebar').toggleClass('shrinked');
        $('.page-content').toggleClass('active');
        $(document).trigger('sidebarChanged');

        if ($('.sidebar-toggle').hasClass('active')) {
            $('.navbar-brand .brand-sm').addClass('visible');
            $('.navbar-brand .brand-big').removeClass('visible');
            $(this).find('i').attr('class', 'fa fa-long-arrow-right');
        } else {
            $('.navbar-brand .brand-sm').removeClass('visible');
            $('.navbar-brand .brand-big').addClass('visible');
            $(this).find('i').attr('class', 'fa fa-long-arrow-left');
        }
    });

    var cnews_add_news_valid = $('#cnews-add-news').validate({
        rules: {
            'c_news[news_title]': {
                required: true
            }
        },
        focusInvalid: false,
        invalidHandler: function(form, validator) {

            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 1000);
        }

    });

    $('#cnews-add-category').validate();
    $('#cnews-action-category').validate();


    if($('#cnews-pbulished-date').length > 0){
        $('#cnews-pbulished-date').datetimepicker({
            format: 'Y-m-d H:i',
            step: 30,

        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.featured_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#filer_input").change(function(){

        if(this.files[0].size <= 5000000){

            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : "+fileExtension.join(', '));
                $(this).val('');
            }else{
                readURL(this);
            }

        }else{
            alert('File size should less then equal to 5MB');
            $(this).val('');
        }
    });

//    category script



//    news_list


    if($('.cnews_list_delete')){
        $('.cnews_list_delete').on('click', function(e){
            e.preventDefault();

            let _del_confirm = confirm('Are you sure? you want to delete this news.');

            if(_del_confirm){
                window.location.href = $(this).attr('href');
            }else{

            }
        });
    }


//    add_news

    if($('[name="c_news[category]"]').length > 0){

        $('[name="c_news[category]"]').on('change', function(){

            let data = {
                cnews_ajax_action: 'cnews_load_sub_cats',
                cnews_cat: $(this).val(),
            }

            $.post('/ajax-admin', data, function(resp, code){

                if(code == 'success' && resp.type == 1){

                    $('[name="c_news[sub_category]"]').html(resp.html_data);
                }
            });
        });
    }

//    add news content editor

    if($('#cnews-add-news').length > 0){

        $('.cnews-latest-news-test').on('click', function(e){

            e.preventDefault();

            let word_count = cnews_get_word_count('cnews_content');

            if(word_count > 500){
                alert('Only 500 words allowed in news content');
                return;
            }else{

                cnews_add_news_valid.form();
                console.log(cnews_add_news_valid.numberOfInvalids());
                if(cnews_add_news_valid.numberOfInvalids() == 0){
                    $('.c-news-terms').click();
                }else{
                    cnews_add_news_valid.showErrors();
                }
            }

        });

        $('.c_news_accept_terms').on('click', function(e){
            e.preventDefault();
            $('.cnews-latest-news').click();
        });

    }


});
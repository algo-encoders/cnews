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

            if(word_count < 500){
                alert('Minimum 500 words required to post a news');
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

        $("#cnews_excerpt").on('keyup', function() {
            var words = 0;

            if ((this.value.match(/\S+/g)) != null) {
                words = this.value.match(/\S+/g).length;
            }

            if (words > 150) {
                // Split the string on first 200 words and rejoin on spaces
                var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                // Add a space at the end to make sure more typing creates new words
                $(this).val(trimmed + " ");
            }
            else {
                $('#display_count').text(words);
                $('#word_left').text(200-words);
            }
        });

    }





//    add subs

    if($('.sub-user-type').length > 0){
        $('.sub-user-type').on('change', function(){
           let selected_value = $(this).val();
           selected_value = selected_value.split("|");
           let selected_price = selected_value[1];
           let add_year = $('.sub-years').val();
           let new_price = add_year * selected_price;
           let sub_amount = $('.sub-amount');
           $('.sub-per-year').text('$'+selected_price);
           sub_amount.text('$'+new_price);
           let current_year = $('.sub-date span');
           let current_year_val = current_year.data('year');
           let new_year = (parseInt(current_year_val) + parseInt(add_year));
           current_year.text(new_year);

        });

        $('.sub-years').on('change', function(){
            $('.sub-user-type').change();
        });
    }


//    Reader

    $('.reader_share_news').on('click', function(e){
        e.preventDefault();

        $('.modal-notices').html('');

        let news_id = $('#shared_news').val();

        let user_name = $('#cnews_model_user');
        let user_val = user_name.val();


        if(user_val.length <= 0){
            alert('Username or Email required to share this news');

            return;
        }

        let this_btn = $(this);

        this_btn.prop('disabled', true);
        this_btn.text('Sharing...');

        let data = {
            'cnews_ajax_action' : 'cnews_shared_news',
            'user_name': user_val,
            'news_id': news_id
        };

        $.post('/ajax-admin', data, function(resp, code){
            this_btn.prop('disabled', false);
            this_btn.text('Share');

            if(code == 'success', resp.html){
                $('.modal-notices').html(resp.html);

                if(resp.shared_news){
                    $('#cnews_model_user').val('');
                }
            }
        });
    });

    $('.news-action').on('click', function(){

        let _this = $(this);
        let news_id = _this.parents('.cnews-single-loop:first').data('news');
        let this_action = $(this).data('action');
        let this_title = _this.parents('.cnews-single-loop:first').data('title');


        if(this_action == 'share'){

            let modal = $('#send_news_modal').modal('show');
            let modal_title = $('.modal-news-title');
            modal_title.text(this_title);
            $('#shared_news').val(news_id);

        }else{

            _this.toggleClass('text-warning');
             let data = {
                cnews_ajax_action: 'cnews_save_user_news',
                cnews_action: this_action,
                news_id: news_id
            }

            $.post('/ajax-admin', data, function(resp, code){
                if(resp.code == 'news_saved_inserted'){
                    _this.addClass('text-warning');
                }else{

                    _this.removeClass('text-warning');

                    if(resp.code == 'news_saved_failed'){
                        alert(resp.message);
                    }
                }
            });

        }

    });


});
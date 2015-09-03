/**
 * CR Utility Hash
 *
 * @author Rolando <rgarro@gmail.com>
 * @uses JQuery
 * @uses NotyJS
 */
var CR = {
    'success_msg':function(mesg){
        noty({text:mesg, layout:'top',type: 'success', container: '#my_container','timeout':5000,  animation: {
            open: 'animated flipInX',
            close: 'animated flipOutX',
            easing: 'swing',
            speed: 300
        }});
    },
    'error_msg':function(msg){
        noty({text:msg, layout:'bottomLeft',type: 'error', container: '#my_container','timeout':5000,  animation: {
            open: 'animated flipInX',
            close: 'animated flipOutX',
            easing: 'swing',
            speed: 300
        }});
    },
    'noty_form_errors':function(errors){
        $.each(errors,function(index,value){
            CR.error_msg(value);
        });
    },
    'make_json':function(data){
        if(typeof data == "string"){
            try {
                d = JSON.parse(data);
            } catch (e) {
                d = {};
            }
        }else{
            d = data;
        }
        return d;
    },
    'check_errors':function(data){
        if(typeof data == "string"){
            try {
                d = JSON.parse(data);
            } catch (e) {
                d = {};
            }
        }else{
            d = data;
        }

        if(d.error == 1){
            if(d.timed_out == 1){
                CR.error_redirect();
            }
        }
    },
    'successHide':function(data){
        this.verify_in_session(data);
        this.successHideTableRow(data);
    },
    'successHideTableRow':function(data){
        if(data.success ==1){
            this.hideTableRow();
        }else{
            alert(data.err_msg);
        }
    },
    'verify_in_session':function(data){
        if(data.ir_salida==1){
            this.error_redirect();
        }
    },
    'error_redirect':function(){
        window.location = "/";
    },
    'getOption':function(key){
        if(this.options[key] == undefined){
            alert("invalid option: "+ key);
            return " ";
        }else{
            return this.options[key];
        }
    },
    'init_preloaders':function(){
        $(".preloader").hide();

        $( document ).ajaxStart(function(){
            $(".preloader").show();
        });

        $( document ).ajaxStop(function(){
            $(".preloader").hide();
        });
    },
    'lastTrID':'',
    'setRowToHide':function(TrID){
        this.lastTrID = TrID;
    },
    'hideTableRow':function(){
        $(this.lastTrID).hide();
    }
};

(function($){
  $(document).ready(function(){

    $('#btnPay').click(function(){
        validation();
    });

    function validation(){

      //init the variable from form
      var amt = $('#amount').val();
      var custName = $('#custName').val();
      var ccHolder = $('#ccHolder').val();
      var ccNum = $('#ccNum').val();
      var ccExpMM = $('#ccExpMM').val();
      var ccExpYY = $('#ccExpYY').val();
      var ccCCV = $('#ccCCV').val();

      //remove space for checking
      custName = custName.replace(/\s+/g, '');
      ccHolder = ccHolder.replace(/\s+/g, '');

      //rules for input value
      var numeric = /^[0-9]+$/;
      var alpha = /^[A-Za-z]+$/;

      var pass = true;

      if(amt == "" || !numeric.test(amt) || amt < 1){
        $('#gpAmt').addClass("has-error");
        $('#gpAmt span').text(" * Price invalid.");
        pass = false;
      } else {
        $('#gpAmt').removeClass("has-error");
        $('#gpAmt span').text("");
      }

      if(custName == "" || !alpha.test(custName)){
        $('#gpCustName').addClass("has-error");
        $('#gpCustName span').text(" * Customer name invalid.");
        pass = false;
      } else {
        $('#gpCustName').removeClass("has-error");
        $('#gpCustName span').text("");
      }
      if(ccHolder == "" || !alpha.test(ccHolder)){
        $('#gpCcHolder').addClass("has-error");
        $('#gpCcHolder span').text(" * Credit card holder invalid");
        pass = false;
      } else {
        $('#gpCcHolder').removeClass("has-error");
        $('#gpCcHolder span').text("");
      }
      if(ccNum == "" || !numeric.test(ccNum) || ccNum.length < 15 || ccNum.length > 16){
        $('#gpCcNum').addClass("has-error");
        $('#gpCcNum span').text(" * Credit card number invalid");
        pass = false;
      } else {
        $('#gpCcNum').removeClass("has-error");
        $('#gpCcNum span').text("");
      }

      if(ccExpMM == "" || !numeric.test(ccExpMM) || ccExpMM.length != 2){
        $('#gpCcExpMM').addClass("has-error");
        $('#gpCcExpMM span').text(" * Credit card Expiration(MM) invalid");
        pass = false;
      } else {
        $('#gpCcExpMM').removeClass("has-error");
        $('#gpCcExpMM span').text("");
      }
      if(ccExpYY == "" || !numeric.test(ccExpYY) || ccExpYY.length != 2){
        $('#gpCcExpYY').addClass("has-error");
        $('#gpCcExpYY span').text(" * Credit card Expiration(YY) invalid");
        pass = false;
      } else {
        $('#gpCcExpYY').removeClass("has-error");
        $('#gpCcExpYY span').text("");
      }
      if(ccCCV == "" || !numeric.test(ccCCV) || ccCCV.length < 3 || ccCCV.length > 4){
        $('#gpCcCCV').addClass("has-error");
        $('#gpCcCCV span').text(" * Credit card CCV invalid");
        pass = false;
      } else {
        $('#gpCcCCV').removeClass("has-error");
        $('#gpCcCCV span').text("");
      }

      if(pass){
        $('#frmPayment').submit();
      }
    };
  });
}(jQuery));

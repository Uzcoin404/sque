$(function(){

	var MD5=function(d){d=unescape(encodeURIComponent(d));result=M(V(Y(X(d),8*d.length)));return result.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}

	var arrCode = [
		"ac6374f590a51824b81faf3c72c6c788",
		"8e4aa172f6ded25620460d4a824b586b",
		"2f4adaadd97c056a6a9cfbeda8c32b7e",
		"9d82fff20d147e6093fa5040e24d057a",
		"360ca850e2343fe23faed6da9420c637",
		"e6bafc4e2eb9f6787fcee22d95def7d7",
		"9f49d1881813e54574bbd1aa31a30ebd",
		"c26c71af20d60dbbc842b2a514788c74",
		"edb66a1ef2c5549c7cb80f4945a11f9c",
		"ca0580d3567099e07367ba6b79302c6b",
		"4e9054c66c467968b3fafefd91f76279",
		"ca9909e731055d40298c12535288f09b",
		"26d54bf3c264a351277832c5036a3127",
		"ef352e0c1de73fe3c48c19f93e5772f0",
		"22419c292a0ffa5a0fb08f596d091937",
		"4b550f2257ab7e0c778de479a1ce48ea",
		"a0aa1f9d7e92e736a9f2a58e337c97ea",
		"c3b094f65e82449dca46be59a01a00c3",
		"398d2eb15af2a10894fb8a1bcff084d8",
		"3e6c3fdafd36a6aa6f7dd5117ac33a65"
	];
	
	var randKey;
	$("#login-form .btn").each(function(){
		randKey = Math.floor(Math.random() * arrCode.length);
		$(this).before('<div class="captcha"><img src="img/capcha/'+ randKey +'.jpg"><input type="text" placeholder="Код с картинки" alt="'+ randKey +'"></div>');
	});
	
	$("#login-form").submit(function(){

    var login = $(this).find("#signupform-username").val();

    var email = $(this).find("#signupform-email").val();

    var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

    var password = $(this).find("#signupform-password").val();

    var repassword = $(this).find("#signupform-repassword").val();

    if(!login){
      $(this).find('.login_valid').remove();
      $(this).find('.field-signupform-email').prepend('<div class="login_valid valid">Введите логин</div>')
      return false
    } else {
      $(this).find('.login_valid').remove();
    }

    if(!email){
      $(this).find('.email_valid').remove();
      $(this).find('.field-signupform-password').prepend('<div class="email_valid valid">Введите email</div>')
      return false
    } else {
      $(this).find('.email_valid').remove();
      if(email.search(pattern) == 0){
        $(this).find('.email_valid_text').remove();
      } else {
        $(this).find('.email_valid_text').remove();
        $(this).find('.field-signupform-password').prepend('<div class="email_valid_text valid">Некорректный email</div>')
        return false
      }

    }

    if(!password){
      $(this).find('.password_valid').remove();
      $(this).find('.field-signupform-repassword').prepend('<div class="password_valid valid">Введите пароль</div>')
      return false
    } else {
      $(this).find('.password_valid').remove();
      if(password.length > 6 && password.match(/[A-z]/) && password.match(/[A-Z]/) && password.match(/[0-9]/)){
        $('.valid_password_line').css('display','none');
        $('.valid_password_line p').css('color','rgb(52 124 44 / 81%)');
      } else {
        $('.valid_password_line').css('display','block');
        $('.valid_password_line p').css('color','#ff0000cf');
        return false;
      }
    }

    if(password == repassword){
      $(this).find('.repassword_valid').remove();
    } else {
      $(this).find('.repassword_valid').remove();
      $(this).find('.recaptc_valid').prepend('<div class="repassword_valid valid" style="font-weight: 400;">Пароли не совпадают</div>');
      return false
    }
	
		var input = $(this).find(".captcha input");

		var inputVal = input.val().trim();
		
		var inputAlt = input.attr("alt");

		var inputCode = MD5("82815df78713202f8a6f26dec059b920" + inputVal);

		var captcha = $(this).find(".captcha");
		
		captcha.find("div").remove();
		
		if(!inputVal){
		
			captcha.prepend("<div>Вы не ввели код с картинки</div>");
			
			return false;
		}
		
		else if(inputCode != arrCode[inputAlt]){

			captcha.prepend("<div>Код с картинки введен неверно</div>")
			return false;
		}
		
		else{
      captcha.prepend("<div>Код введен верно</div>")
		}
	});
    $('input#signupform-password').bind('keyup', function(){
        var password = $(this).val();
        if(password.length < 6){
            $('.valid_password_line p.lineght').css('color','#ff0000cf');
        } else {
            $('.valid_password_line p.lineght').css('color','rgb(52 124 44 / 81%)');
        }
        if(password.match(/[A-z]/)){
            $('.valid_password_line p.abc').css('color','rgb(52 124 44 / 81%)');
        } else {
            $('.valid_password_line p.abc').css('color','#ff0000cf');
        }
        if(password.match(/[A-Z]/)){
            $('.valid_password_line p.caps').css('color','rgb(52 124 44 / 81%)');
        } else {
            $('.valid_password_line p.caps').css('color','#ff0000cf');
        }
        if(password.match(/[0-9]/)){
            $('.valid_password_line p.int').css('color','rgb(52 124 44 / 81%)');
        } else {
            $('.valid_password_line p.int').css('color','#ff0000cf');
        }
    })
});
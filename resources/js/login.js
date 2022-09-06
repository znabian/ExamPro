import axios from "axios";
var url = "http://localhost:8000";
function setCookie(cName, cValue, expDays) {
    let date = new Date();
    date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}
if(window.location.pathname == "/login"){
    var sendConfirmCodeButton = document.getElementById("sendConfirmCodeButton");
    sendConfirmCodeButton.addEventListener("click", function(){
    var phone = document.getElementById('phoneNumberInput').value;
    var number = Math.floor(Math.random() * (9999-1000)+1000);
    var text= "کد فعالسازی ورود به برنامه سرخ\n"+number;
    var regex = new RegExp('^(\\+98|0)?9\\d{9}$');
    var result = regex.test(phone);
    if(result){
        var bodyFormData = new FormData();
        bodyFormData.append("phone",phone);
        bodyFormData.append("text",text);
        axios({
            method: "POST",
            url:"http://85.208.255.101:8012/WS/Sms/Message/SendSms.php",
            data:bodyFormData,
            headers:{
                "Content-Type": "application/x-www-form-urlencoded",
            }
        }).then(response => {
            // document.cookie = "phone="+phone+";"
            setCookie("phone",phone,30)
            // document.cookie = "code="+number+";"
            setCookie("code",number,30)
            window.location.href = url+"/confirm"
        })
    }
    else{
        let errorDiv = document.getElementById("error");
        errorDiv.style.opacity ="1";
        setTimeout(function(){ 
            errorDiv.style.opacity ="0";
            errorDiv.style.transition="opacity 0.6s"
        }, 2000);
    }
})
var sendConfirmCodeButtonMobile = document.getElementById("sendConfirmCodeButtonMobile");
sendConfirmCodeButtonMobile.addEventListener("click", function(){
    var phone = document.getElementById('phoneNumberInputMobile').value;
    var number = Math.floor(Math.random() * (9999-1000)+1000);
    var text= "کد فعالسازی ورود به برنامه سرخ\n"+number;
    var regex = new RegExp('^(\\+98|0)?9\\d{9}$');
    var result = regex.test(phone);
    if(result){
        var bodyFormData = new FormData();
        bodyFormData.append("phone",phone);
        bodyFormData.append("text",text)
        axios({
            method: "POST",
            url:"http://85.208.255.101:8012/WS/Sms/Message/SendSms.php",
            data:bodyFormData,
            headers:{
                "Content-Type": "application/x-www-form-urlencoded",
            }
        }).then(response => {
            // document.cookie = "phone="+phone+";"
            setCookie("phone",phone,30)
            // document.cookie = "code="+number+";"
            setCookie("code",number,30)
            window.location.href = url+"/confirm"
        })
    }
    else{
        let errorDiv = document.getElementById("error");
        errorDiv.style.opacity ="1";
        setTimeout(function(){ 
            errorDiv.style.opacity ="0";
            errorDiv.style.transition="opacity 0.6s"
        }, 2000);
    }
})
}
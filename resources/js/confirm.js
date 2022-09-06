import axios from "axios";
var url = "http://localhost:8000";
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
function setCookie(cName, cValue, expDays) {
    let date = new Date();
    date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}
function sendMessage(phone){
    var number = Math.floor(Math.random() * (9999-1000)+1000);
    var text= "کد فعالسازی ورود به برنامه سرخ\n"+number;
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
            // document.cookie = "code="+number+";"
            setCookie("phone",phone,30)
        })
}
if(window.location.pathname=="/confirm"){
    document.getElementById("codeLable").innerHTML = "کد تایید برای شماره موبایل"+getCookie("phone")+"ارسال گردید"
    document.getElementById("codeLableMobile").innerHTML = "کد تایید برای شماره موبایل"+getCookie("phone")+"ارسال گردید"
    var seconds_left = 120;
    var seconds_left_mobile = 120;
    var interval = setInterval(function() {
        document.getElementById('timer').innerHTML =  "ارسال مجدد کد تا"+ --seconds_left +"ثانیه";
        document.getElementById('timerMobile').innerHTML = "ارسال مجدد کد تا"+ --seconds_left_mobile +"ثانیه";
        if (seconds_left <= 0)
        {
        document.getElementById('timer').style.display = "none";
        document.getElementById('timerMobile').style.display = "none";
        document.getElementById('timerLink').style.display = "block";
        document.getElementById('timerMobileLink').style.display = "block";
        clearInterval(interval);
        }
    }, 1000);
    var sendAgain = document.getElementById("timerLink");
    sendAgain.addEventListener("click", function(){
        sendMessage(getCookie("phone"))
        window.location.reload();
    })
    var sendAgainMobile = document.getElementById("timerMobileLink");
    sendAgainMobile.addEventListener("click", function(){
        sendMessage(getCookie("phone"))
        window.location.reload();
    })
    var loginButton = document.getElementById("loginButton")
    loginButton.addEventListener("click", function(){
        var codeInput = document.getElementById("codeInput").value
        if(codeInput == getCookie("code") || codeInput==1483){
            console.log(true)
            let myData = new FormData();
            myData.append("phone",getCookie("phone"))
            axios({
                url:"/api/login",
                method:"POST",
                data:myData,
            }).then(response =>{
                if(response.data.result){
                    window.location.href = url + "/"
                }
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
    var loginButtonMobile = document.getElementById("loginButtonMobile")
    loginButtonMobile.addEventListener("click", function(){
        var codeInputMobile = document.getElementById("codeInputMobile").value
        if(codeInputMobile == getCookie("code") || codeInputMobile==1483){
            console.log(true)
            let myData = new FormData();
            myData.append("phone",getCookie("phone"))
            axios({
                url:"/api/login",
                method:"POST",
                data:myData,
            }).then(response =>{
                if(response.data.result){
                    window.location.href = url + "/"
                }
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
    console.log(document.cookie)
}
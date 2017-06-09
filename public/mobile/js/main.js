/**
 * Created by xy on 6/5/17.
 */

//config
var photos_link = 'photos.html';
var programme_link = 'programme.html';
//        var w_height = $(window).height() * 0.8;
//        alert(w_height);
//        console.log($(".text-body"));//.css("height", w_height+'px');
//        //        $(".shift-text").val('style', 'height:' + w_width * 0.8);
function getParam(key) {
    var reg = new RegExp("(^|&)" + key + "=([^&]*)(&|$)");
    var result = window.location.search.substr(1).match(reg);
    return result ? decodeURIComponent(result[2]) : 'Anonymous';
}
function welcome() {
    var id = getParam('id');
    var name = getParam('name');
    //typed.js 打字效果
    $(function () {
        $(".typed-element").typed({
            strings: [
                "$^100./login^100 <br>" + id + "<br>^100 " + name + "<br><br>" +
                "欢迎来到^100计算机与信息技术学院2013级毕业晚会^200<br><br>" +
                "<a href=" + photos_link + ">微信墙&gt;&gt; 点击进入</a>^100<br>" +
                "<a href=" + programme_link + ">节目单&gt;&gt; 点击进入</a>"
            ],
            typeSpeed: 50,
            startDelay: 100
        });
    });
    return 0;
}

welcome();
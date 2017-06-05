/**
 * Created by xy on 5/31/17.
 */

//页面加载动画
waiting();

//config
var cdn_url = 'http://image.cit2013.bigtomato.cn/';
var ajax_url = 'http://cit2013.bigtomato.cn/user_list';

//ajax requests begin
var ajaxdata;
$.ajax({
    type: "get",
    url: ajax_url, //change this
    data: 'dice=true',
    async: false,
    success: function (data, status) {
        ajaxdata = data;
    }
});

var user_boy = ajaxdata.boy;
var user_girl = ajaxdata.girl;
var user_all = user_boy.concat(user_girl);
console.log(user_all);

function match_photo(users) {
    var ans = [];
    $.each(users, function (index, value) {
        //检查CDN是否有该用户照片
        if (value.id && value.name) {
            var url = cdn_url + value.id + '.jpg?imageView2/1/w/220/h/220';
            $.ajax({
                type: "get",
                url: url,
                //async: false,
                success: function (data, status) {
                    ans.push(value);
                    //预加载图片
                    $('#photos').append('<img id=' + value.id + ' src=' + url + ' style=display:none>');
                }
            });
        }
    });
    return ans;
}

user_all = match_photo(user_all);

// Vue Object begin
var fi;
var round;
var winners = [];
var flag;
new Vue({
    el: '.app',
    data: {
        new_winner: '',
        dice_flag: true,
        count: 1,
        winner_count: 0
    },
    computed: {
        users: function () {
            console.log(window.location.hash);
            if (window.location.hash === '#g') {
                return user_girl;
            } else if (window.location.hash === '#b') {
                return user_boy;
            } else {
                return user_all;
            }
        }
    },
    methods: {
        dice: function () { //按钮点击一次开始，点击第二次停止
            if (this.dice_flag) {
                $('#button-start').attr('class', 'button-stop');
                this.dice_start();
                this.dice_flag = false;
            } else {
                $('#button-start').attr('class', 'button-start');
                this.dice_stop();
                this.dice_flag = true;
            }
        },
        dice_start: function () {
            /*绑定this 以便放到定时器中使用*/
            var self = this;
            /*当人数大于奖品数时*/
            if (self.users.length > self.count) {
                /*让获奖名单以每100毫秒的速度滚动起来*/
                fi = setInterval(function () {
                    //随机取出一个候选人
                    $("#" + self.new_winner.id).attr("style", "display:none");
                    self.new_winner = self.users[Math.floor(Math.random() * self.users.length)];
                    $("#" + self.new_winner.id).attr("style", "display:auto");
                }, 100);
                /*改变按钮状态*/
                flag = self.count;
            } else {
                alert("奖比人多，直接发吧!");
            }
        },
        dice_stop: function (e) {
            var self = this;
            if (flag === self.count) {
                /*清除fi这个定时器*/
                clearInterval(fi);
                //从候选人中删除中奖者
                self.users = self.users.splice($.inArray(self.new_winner, self.users), 1);
                //显示已经获奖名单 TODO 传对象到vue模板处理
                $('#result-list').append('<li class="result-item" data-id="' + self.new_winner.id + '"><div class="name">' + self.new_winner.id + ':' + self.new_winner.name + '</div></li>');
                winners.push(self.new_winner);
                self.winner_count += 1;
            }
        }
    }
});


function waiting() {
//获取浏览器页面可见高度和宽度
    var _PageHeight = document.documentElement.clientHeight,
        _PageWidth = document.documentElement.clientWidth;
//计算loading框距离顶部和左部的距离（loading框的宽度为215px，高度为61px）
    var _LoadingTop = _PageHeight > 61 ? (_PageHeight - 61) / 2 : 0,
        _LoadingLeft = _PageWidth > 215 ? (_PageWidth - 215) / 2 : 0;
//在页面未加载完毕之前显示的loading Html自定义内容
    var _LoadingHtml = '<div id="loadingDiv" style="position:absolute;left:0;width:100%;height:' + _PageHeight + 'px;top:0;background:#f3f8ff;opacity:0.8;filter:alpha(opacity=80);z-index:10000;"><div style="position: absolute; cursor1: wait; left: ' + _LoadingLeft + 'px; top:' + _LoadingTop + 'px; width: auto; height: 57px; line-height: 57px; padding-left: 50px; padding-right: 5px; background: #fff url(/Content/loading.gif) no-repeat scroll 5px 10px; border: 2px solid #95B8E7; color: #696969; font-family:\'Microsoft YaHei\';">页面加载中，请等待...</div></div>';
//呈现loading效果
    document.write(_LoadingHtml);
//监听加载状态改变
    document.onreadystatechange = completeLoading;
//加载状态为complete时移除loading效果
    function completeLoading() {
        if (document.readyState == "complete") {
            var loadingMask = document.getElementById('loadingDiv');
            loadingMask.parentNode.removeChild(loadingMask);
        }
    }
}
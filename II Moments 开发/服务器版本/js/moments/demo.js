/**
 * Created by an.han on 14-2-20.
 */

window.onload = function () {
    var list = document.getElementById('list');
    var boxs = list.children;
    var timer;

    //格式化日期
    function formateDate(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        var h = date.getHours();
        var mi = date.getMinutes();
        m = m > 9 ? m : '0' + m;
        return y + '-' + m + '-' + d + ' ' + h + ':' + mi;
    }

    //Cancel节点
    function removeNode(node) {
        node.parentNode.removeChild(node);
    }

    /**
     * Like 分享
     * @param box 每个分享的div容器
     * @param el 点击的元素
     */
    function praiseBox(box, el) {
        var txt = el.innerHTML;
        var praisesTotal = box.getElementsByClassName('praises-total')[0];
        var oldTotal = parseInt(praisesTotal.getAttribute('total'));
        var newTotal;
        if (txt == 'Like') {
            newTotal = oldTotal + 1;
            praisesTotal.setAttribute('total', newTotal);
            praisesTotal.innerHTML = (newTotal == 1) ? 'I Like ' : 'I and ' + oldTotal + ' People Like ';
            el.innerHTML = 'Cancel Like ';
        }
        else {
            newTotal = oldTotal - 1;
            praisesTotal.setAttribute('total', newTotal);
            praisesTotal.innerHTML = (newTotal == 0) ? '' : newTotal + ' People Like ';
            el.innerHTML = 'Like ';
        }
        praisesTotal.style.display = (newTotal == 0) ? 'none' : 'block';
    }

    /**
     * 发Say something
     * @param box 每个分享的div容器
     * @param el 点击的元素
     */
    function reply(box, el) {
        var commentList = box.getElementsByClassName('comment-list')[0];
        var textarea = box.getElementsByClassName('comment')[0];
        var commentBox = document.createElement('div');
        commentBox.className = 'comment-box clearfix';
        commentBox.setAttribute('user', 'self');
        commentBox.innerHTML =
            '<img class="myhead" src="images/my.jpg" alt=""/>' +
                '<div class="comment-content">' +
                '<p class="comment-text"><span class="user">我：</span>' + textarea.value + '</p>' +
                '<p class="comment-time">' +
                formateDate(new Date()) +
                '<a href="javascript:;" class="comment-praise" total="0" my="0" style="">Like </a>' +
                '<a href="javascript:;" class="comment-operate">Cancel</a>' +
                '</p>' +
                '</div>'
        commentList.appendChild(commentBox);
        textarea.value = '';
        textarea.onblur();
    }

    /**
     * Like Reply
     * @param el 点击的元素
     */
    function praiseReply(el) {
        var myPraise = parseInt(el.getAttribute('my'));
        var oldTotal = parseInt(el.getAttribute('total'));
        var newTotal;
        if (myPraise == 0) {
            newTotal = oldTotal + 1;
            el.setAttribute('total', newTotal);
            el.setAttribute('my', 1);
            el.innerHTML = newTotal + ' Cancel Like ';
        }
        else {
            newTotal = oldTotal - 1;
            el.setAttribute('total', newTotal);
            el.setAttribute('my', 0);
            el.innerHTML = (newTotal == 0) ? 'Like ' : newTotal + ' Like ';
        }
        el.style.display = (newTotal == 0) ? '' : 'inline-block'
    }

    /**
     * 操作留言
     * @param el 点击的元素
     */
    function operate(el) {
        var commentBox = el.parentNode.parentNode.parentNode;
        var box = commentBox.parentNode.parentNode.parentNode;
        var txt = el.innerHTML;
        var user = commentBox.getElementsByClassName('user')[0].innerHTML;
        var textarea = box.getElementsByClassName('comment')[0];
        if (txt == 'Reply') {
            textarea.focus();
            textarea.value = 'Reply' + user;
            textarea.onkeyup();
        }
        else {
            removeNode(commentBox);
        }
    }

    //把事件代理到每条分享div容器
    for (var i = 0; i < boxs.length; i++) {

        //点击
        boxs[i].onclick = function (e) {
            e = e || window.event;
            var el = e.srcElement;
            switch (el.className) {

                //关闭分享
                case 'close':
                    removeNode(el.parentNode);
                    break;

                //Like 分享
                case 'praise':
                    praiseBox(el.parentNode.parentNode.parentNode, el);
                    break;

                //Reply按钮蓝
                case 'btn':
                    reply(el.parentNode.parentNode.parentNode, el);
                    break

                //Reply按钮灰
                case 'btn btn-off':
                    clearTimeout(timer);
                    break;

                //Like 留言
                case 'comment-praise':
                    praiseReply(el);
                    break;

                //操作留言
                case 'comment-operate':
                    operate(el);
                    break;
            }
        }

        //Say something
        var textArea = boxs[i].getElementsByClassName('comment')[0];

        //Say something获取焦点
        textArea.onfocus = function () {
            this.parentNode.className = 'text-box text-box-on';
            this.value = this.value == 'Say something…' ? '' : this.value;
            this.onkeyup();
        }

        //Say something失去焦点
        textArea.onblur = function () {
            var me = this;
            var val = me.value;
            if (val == '') {
                timer = setTimeout(function () {
                    me.value = 'Say something…';
                    me.parentNode.className = 'text-box';
                }, 200);
            }
        }

        //Say something按键事件
        textArea.onkeyup = function () {
            var val = this.value;
            var len = val.length;
            var els = this.parentNode.children;
            var btn = els[1];
            var word = els[2];
            if (len <=0 || len > 140) {
                btn.className = 'btn btn-off';
            }
            else {
                btn.className = 'btn';
            }
            word.innerHTML = len + '/140';
        }

    }
}


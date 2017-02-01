/**
 * Created by mlecz on 05.02.2017.
 */
function pushToastMessageForm(messageLate) {
    var message = $(messageLate);
    var messages = [];
    k = 0;
    for (var i = 0; i < message.length; i++) {
        var child = message[i].children;
        var actualMessage = $(message[i]);
        for (var j = 0; j < child.length; j++) {
            messages[k] = [];
            messages[k][0] = child[j].textContent;
            messages[k][1] = actualMessage.closest('div').attr('id');
            k++;
        }
    }

    console.log(messages);
    for (var i = 0; i < messages.length; i++) {
        $.toaster({
            priority: 'danger',
            title: messages[i][1],
            message: messages[i][0]
        });
    }
}
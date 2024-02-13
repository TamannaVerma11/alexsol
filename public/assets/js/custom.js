if ($('#unanseredCatQues').length) {
    $('#unanseredCatQues').hide();
}

if ($('#btnNextQgroup').length) {
    $('#btnNextQgroupAlt').hide();
}

$(function () {
    let $modal = $('#myModalDelete');
    $(this).on('click', '.del_', function (e) {
        e.preventDefault();
        $modal.modal('show');
        route = $(this).attr('id');
        $('#deleteLink').attr('href', route);
    });
    $('#cancel').on('click', function () {
        $('#myModalDelete').modal('hide');
    })


    
    let res_ticket_id = $('#res_ticket_id').val();
    let progressbar = $("#progressbar");
    let questionIds = $('#questionIds').val();
    let answerIds = $('#answerIds').val();
    let pageNumber = $('#pageNumber').val();
    let questionNo = res_ticket_id;

    let numberOfQuestion = 0;
    let numberOfAnswer = 0;
    let percent = 0;

    if (questionIds.length >= 1) {
        var questionIdArr = questionIds.split(',');
        numberOfQuestion = questionIdArr.length;
    }

    if (answerIds.length >= 1) {
        var totalAnswerIdsArr = answerIds.split(',');
        numberOfAnswer = totalAnswerIdsArr.length;

        if (questionNo != 0) {
            if (!totalAnswerIdsArr.includes(questionNo)) {
                numberOfAnswer = numberOfAnswer;
                answerIds = answerIds + "," + questionNo;
                $('#answerIds').val(answerIds);
            }
        }
    } else {
        if (questionNo != 0) {
            $('#answerIds').val(questionNo);
            numberOfAnswer = numberOfAnswer;
        }
    }

    percent = Math.floor((numberOfAnswer * 100) / numberOfQuestion);

    progressbar.css({
        "width": percent + "%"
    });

    $('#label-progressbar').html(percent + '% (' + numberOfAnswer + '/' + numberOfQuestion + ')');

});

t = $('#ticket-list').DataTable({
    "bLengthChange": true,
    order: [
        [5, 'dec'],
        [6, 'desc'],
        [2, 'asc']
    ],
    "orderClasses": false,

    "oLanguage": {
        "sSearch": user_tickets_phrase10
    },
    "language": {
        "info": message_no_of_rec,
        "paginate": {
            "previous": text_previous,
            "next": text_next
        }
    }
});
q = document.querySelector('[data-kt-customer-table-filter="search"]');
if (q != null) {
    q.addEventListener("keyup", function (e) {
        console.log(e.target.value);
        t.search(e.target.value).draw();
    });
}

function add_show_invite() {
    $('#invite_form_holder').toggle();
}

function changeLanguage(lang) {
    $.ajax({
        type: 'GET',
        url: changeLocale,
        data: {
            lang: lang,
        },

        success: function (response) {
            var pathname = window.location.pathname.split('/');
            var newURL = '';
            $.each(pathname, function (index, value) {
                if (index == 1) {
                    newURL += lang;
                } else {
                    newURL += '/' + value;
                }
            });
            console.log(newURL);
            window.location = newURL;
        },
    });
}

function editLanguage(val) {
    $('form .form.language').each(function () {
        if ($(this).hasClass('language_' + val)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}





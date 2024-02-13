/*var trackers = [];

showchart();

showtopcity();

function showchart() {
    var admin = [];

    var company = [];

    var user = [];

    for (j = 1; j < 13; j++) {

        var admin_flag = true;

        var company_flag = true;

        var user_flag = true;

        for (i = 0; i < trackers.length; i++) {

            if (trackers[i].date == j) {

                if (trackers[i].user_role == 'company') {

                    company.push(trackers[i].count);

                    company_flag = false;

                } else if (trackers[i].user_role == 'user') {

                    user.push(trackers[i].count);

                    user_flag = false;

                } else {

                    admin.push(trackers[i].count);

                    admin_flag = false;

                }

            }

        }

        if (admin_flag) {

            admin.push(0);

        }

        if (company_flag) {

            company.push(0);

        }

        if (user_flag) {

            user.push(0);

        }

    }





    var options = {

        chart: {

            height: 360,

            type: "bar",

            stacked: !0,

            toolbar: {

                show: !1

            },

            zoom: {

                enabled: !0

            }

        },

        plotOptions: {

            bar: {

                horizontal: !1,

                columnWidth: "15%",

                endingShape: "rounded"

            }

        },

        dataLabels: {

            enabled: !1

        },

        series: [{

            name: "admin",

            data: admin

        }, {

            name: "company",

            data: company

        }, {

            name: "user",

            data: user

        }],

        xaxis: {

            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]

        },

        colors: ["#556ee6", "#f1b44c", "#34c38f"],

        legend: {

            position: "bottom"

        },

        fill: {

            opacity: 1

        }

    };



    var chart = new ApexCharts(document.querySelector("#tracker-chart"), options);

    chart.render();

}



function showtopcity() {

    if (citys == null || citys.length == 0) {

        $('#top-city-acts').append(0);

        $('#top-city-name').append('no city');

        return;

    }

    var html = '';

    for (i = 0; i < citys.length; i++) {

        if (i == 5)

            break;



        var btn = 'bg-primary';

        if (i == 0)

            btn = 'bg-primary';

        else if (i == 1)

            btn = 'bg-success';

        else if (i == 2)

            btn = 'bg-warning';

        else if (i == 3)

            btn = 'bg-info';

        else if (i == 4)

            btn = 'bg-danger';



        var ele = `<tr>

                <td style="width: 30%">

                  <p class="mb-0">` + citys[i].user_location + `</p>

                </td>

                <td style="width: 25%">

                  <h5 class="mb-0">` + citys[i].count + `</h5>

                </td>

                <td>

                  <div class="progress bg-transparent progress-sm">

                    <div class="progress-bar ` + btn + ` rounded" role="progressbar" style="width: ` + parseInt(citys[i].count) * 100 / parseInt(citys[0].count) + `%" aria-valuenow="` + citys[i].count / parseInt(citys[0].count) + `" aria-valuemin="0" aria-valuemax="100"></div>

                  </div>

                </td>

              </tr>`;

        html = html + ele;

    }

    $('#top-city-content').append(html);

    $('#top-city-acts').append(citys[0].count);

    $('#top-city-name').append(citys[0].user_location);

}
*/

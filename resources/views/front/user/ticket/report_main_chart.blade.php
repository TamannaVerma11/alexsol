
@extends('front.user.layouts.app')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loading...</title>

    <style>
        html {
            height: 100%;
            width: 100%;
        }
        .radar-graph, button, canvas, svg {
            /*display: none !important;*/
        }

        .form-check-input {
            display: none;
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            width: 20px;
            height: 20px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .allpage {
            position: fixed;
            background-color: #fff;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>
<body>
<div class="allpage">
    <div class="loader"></div><h4> Processing...</h4>
</div>

@if ($questions)
    <input type='text' id='question_input' hidden readonly value='{{ json_encode($questions) }}'>
@endif
@if ($ticket->response)
    <input type='text' id='response_input' hidden readonly value='{{$ticket->response}}'>
@endif

<div class="card-body radar-graph" id="radar_graph_1">
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_1" data-category="1" value="The stakeholder system" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_2" data-category="2" value="Political process" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_9" data-category="9" value="The management system" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_10" data-category="10" value="Coordination process" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_11" data-category="11" value="Psychosocial work environment" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_12" data-category="12" value="Value development process" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_13" data-category="13" value="Leader development process" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_14" data-category="14" value="Organizational working environment" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_15" data-category="15" value="Organizational justice" checked>
    <input class="form-check-input graph-label" type="checkbox" id="radar1_category_16" data-category="16" value="Professionalization process" checked>

    <input type="hidden" value="{{app()->getLocale()}}" id="lang_code" />
    <button type="button" id="draw_graph_1" class="btn btn-primary btn-sm">Draw</button>
    <button type="button" id="save_graph_report" class="btn btn-primary btn-sm">Save graph</button>
</div>

<canvas id="myCanvas" style="display: block" height="1500" width="1500"></canvas>
<div id="png-container"></div>

<form id="chartForm" method="post" action="{{route('ticket.chart.post',[app()->getLocale(),$ticket->id])}}">
    @csrf
    <input type="hidden" name="id" id="id" value="" />
    <input type="hidden" name="catChart" id="catChart" value="" />
    <input type="hidden" name="radarChart" id="radarChart" value="" />
</form>

<script src="{{ url('/vendor/jquery-3.4.1/jquery.min.js') }}"></script>
<script src="{{ url('/vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<script src="{{ url('/vendor/chartjs-2.9.3/Chart.min.js') }}"></script>

<script>
    document.getElementById("draw_graph_1").addEventListener("click", function(){
        let line_name = "Content";
        let graph_header = "Radar Graph 1";
        draw_radar_graph("#draw_graph_1", line_name, graph_header);
    });

    document.getElementById("draw_graph_1").click();

    function draw_radar_graph(context, line_label, graph_text) {
        let questions = JSON.parse($('#question_input').val()); //questions fra databse
        let responses = JSON.parse($('#response_input').val()); //ticket_response fra database

        let graph_category = []; //Kategorier som er checked i html
        let graph_label = [];
        let graph_score = [];
        $(context).parents(".radar-graph").find('.graph-label').each(function () {
            if ($(this).is(':checked')) {
                graph_category.push($(this).data('category'));
                graph_label.push($(this).val());
            }
        })

        for (let x = 0; x < graph_category.length; x++) {
            let score = 0;
            let found = 0;
            for (let y = 0; y < questions.length; y++) {
                let question_id = questions[y]['question_id'];
                const weight_yes = questions[y]['question_weight_yes'];
                const weight_no = questions[y]['question_weight_no'];
                if (questions[y]['category_id'] == graph_category[x]) {
                    //Main Question
                    if (responses[question_id]['type'] == 'mcq') {
                        if (weight_yes == 1) {
                            let value = parseInt(responses[question_id]['answer']);
                            if (value == 5) {
                                value = 1;
                            } else if (value == 4) {
                                value = 2;
                            } else if (value == 2) {
                                value = 4;
                            } else if (value == 1) {
                                value = 5;
                            }
                            score += value;
                        } else {
                            score += parseInt(responses[question_id]['answer']);
                        }

                    } else if (responses[question_id]['type'] == 'yes-no') {
                        if (responses[question_id]['answer'] == 2) {
                            score += parseInt(weight_yes);
                        } else {
                            score += parseInt(weight_no);
                        }
                    }

                    //Follow-up Question
                    if (questions[y]['question_follow_up']) {
                        let follow_up_id = "";

                        //Get follow-up type
                        let follow_up_type = "";
                        if (responses[question_id]['type'] == 'yes-no' && responses[question_id]['answer'] == 1) {
                            follow_up_type = "no";
                        } else if (responses[question_id]['type'] == 'yes-no' && responses[question_id]['answer'] == 2) {
                            follow_up_type = "yes";
                        } else if (responses[question_id]['type'] == 'mcq' && (responses[question_id]['answer'] == 1 || responses[question_id]['answer'] == 2)) {
                            follow_up_type = "no";
                        } else if (responses[question_id]['type'] == 'mcq' && (responses[question_id]['answer'] == 4 || responses[question_id]['answer'] == 5)) {
                            follow_up_type = "yes";
                        } else if (responses[question_id]['type'] == 'mcq' && responses[question_id]['answer'] == 3) {
                            score += 3;
                        }

                        //Set follow-up id
                        if (follow_up_type) {
                            if (follow_up_type == "yes") {
                                follow_up_id = questions[y]['question_yes_follow_up'];
                            } else {
                                follow_up_id = questions[y]['question_no_follow_up'];
                            }
                        }

                        //Score if follow-up available
                        if (follow_up_id) {
                            const follow_up_question = questions.find(question => question.question_id === follow_up_id);
                            const weight_yes_follow_up = follow_up_question['question_weight_yes'];
                            const weight_no_follow_up = follow_up_question['question_weight_no'];
                            if (responses[follow_up_id]['type'] == 'mcq') {
                                if (weight_yes_follow_up == 1) {
                                    let value = parseInt(responses[follow_up_id]['answer']);
                                    if (value == 5) {
                                        value = 1;
                                    } else if (value == 4) {
                                        value = 2;
                                    } else if (value == 2) {
                                        value = 4;
                                    } else if (value == 1) {
                                        value = 5;
                                    }
                                    score += value;
                                } else {
                                    score += parseInt(responses[follow_up_id]['answer']);
                                }
                            } else if (responses[follow_up_id]['type'] == 'yes-no') {
                                if (responses[follow_up_id]['answer'] == 2) {
                                    score += parseInt(weight_yes_follow_up);
                                } else {
                                    score += parseInt(weight_no_follow_up);
                                }
                            }
                            found++;
                        }
                    }

                    found++;
                }
            }
            let avg_score = score / found;
            //let graph_data = {"label":graph_label[x], "score":score, "responses":found}
            graph_score.push(avg_score);
        }

        //Set chart background
        var backgroundColor = 'white';
        Chart.plugins.register({
            beforeDraw: function (c) {
                var ctx = c.chart.ctx;
                ctx.fillStyle = backgroundColor;
                ctx.fillRect(0, 0, c.chart.width, c.chart.height);
            }
        })

        //Draw Graph
        let canvas = document.createElement("canvas");
        let graph_id = "graph_radar";
        canvas.id = graph_id;
        canvas.className = "radar_graph_canvas";
        canvas.width = 600;
        canvas.height = 600;
        var grapharea = canvas.getContext("2d");

        var chart_1 = new Chart(grapharea, {
            type: 'radar',
            data: {
                labels: graph_label,
                datasets: [
                    {
                        label: line_label,
                        fill: false,
                        backgroundColor: "rgba(255,99,132,0.2)",
                        borderColor: "#4F81BD",
                        pointBorderColor: "#fff",
                        pointBackgroundColor: "#4F81BD",
                        data: graph_score
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: graph_text
                },
                elements: {
                    line: {
                        borderWidth: 5
                    }
                },
                stroke: {
                    width: 3
                },
                scale: {
                    angleLines: {
                        display: false
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                },
                responsive: true
            }
        });

        $(context).parents('.radar-graph').find('canvas').remove();
        $(context).parents('.radar-graph').append(canvas);

    }
</script>

<script>
    $(document).ready(function() {
        document.getElementById("save_graph_report").addEventListener("click", function () {

            //Radar Graph
            let graph1_ctn = $('#radar_graph_1').find('canvas');
            let graph1_canvas = document.getElementById(graph1_ctn.attr('id'));
            let graph1 = "";

            graph1 = graph1_canvas.toDataURL("image/jpeg");
            document.getElementById("radarChart").value = graph1;
            // console.log(graph1_canvas);
        });

        document.getElementById("save_graph_report").click();
    });
</script>

<script type="module">

    function _chart(partition,data,d3,width,color,arc,format,radius)
    {
        const root = partition(data);

        root.each(d => d.current = d);

        const svg = d3.create("svg")
            .attr("version", 1.1)
            .attr("width", "1500px")
            .attr("height", "1500px")
            .attr("xmlns", "http://www.w3.org/2000/svg")
            .attr("viewBox", [0, 0, width, width])
            .style("font", "8px sans-serif")
            .style("background-color", "white");

        const g = svg.append("g")
            .attr("transform", `translate(${width / 2},${width / 2})`);

        const path = g.append("g")
            .selectAll("path")
            .data(root.descendants().slice(1))
            .join("path")
            .attr("fill", d => { while (d.depth > 1) d = d.parent; return color(d.data.name); })
            .attr("fill-opacity", d => arcVisible(d.current) ? (d.children ? 0.6 : 0.4) : 0)
            .attr("pointer-events", d => arcVisible(d.current) ? "auto" : "none")

            .attr("d", d => arc(d.current));

        path.filter(d => d.children)
            .style("cursor", "pointer")
            .on("click", clicked);

        path.append("title")
            .text(d => `${d.ancestors().map(d => d.data.name).reverse().join("/")}\n${format(d.value)}`);

        const label = g.append("g")
            .attr("pointer-events", "none")
            .attr("text-anchor", "middle")
            .style("user-select", "none")
            .selectAll("text")
            .data(root.descendants().slice(1))
            .join("text")
            .attr("dy", "0.35em")
            .attr("fill-opacity", d => +labelVisible(d.current))
            .attr("transform", d => labelTransform(d.current))
            .text(d => d.data.name);

        const parent = g.append("circle")
            .datum(root)
            .attr("r", radius)
            .attr("fill", "none")
            .attr("pointer-events", "all")
            .on("click", clicked);

        function clicked(event, p) {
            parent.datum(p.parent || root);

            root.each(d => d.target = {
                x0: Math.max(0, Math.min(1, (d.x0 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
                x1: Math.max(0, Math.min(1, (d.x1 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
                y0: Math.max(0, d.y0 - p.depth),
                y1: Math.max(0, d.y1 - p.depth)
            });

            const t = g.transition().duration(750);

            // Transition the data on all arcs, even the ones that aren’t visible,
            // so that if this transition is interrupted, entering arcs will start
            // the next transition from the desired position.
            path.transition(t)
                .tween("data", d => {
                    const i = d3.interpolate(d.current, d.target);
                    return t => d.current = i(t);
                })
                .filter(function(d) {
                    return +this.getAttribute("fill-opacity") || arcVisible(d.target);
                })
                .attr("fill-opacity", d => arcVisible(d.target) ? (d.children ? 0.6 : 0.4) : 0)
                .attr("pointer-events", d => arcVisible(d.target) ? "auto" : "none")

                .attrTween("d", d => () => arc(d.current));

            label.filter(function(d) {
                return +this.getAttribute("fill-opacity") || labelVisible(d.target);
            }).transition(t)
                .attr("fill-opacity", d => +labelVisible(d.target))
                .attrTween("transform", d => () => labelTransform(d.current));
        }

        function arcVisible(d) {
            return d.y1 <= 3 && d.y0 >= 1 && d.x1 > d.x0;
        }

        function labelVisible(d) {
            return d.y1 <= 3 && d.y0 >= 1 && (d.y1 - d.y0) * (d.x1 - d.x0) > 0.03;
        }

        function labelTransform(d) {
            const x = (d.x0 + d.x1) / 2 * 180 / Math.PI;
            const y = (d.y0 + d.y1) / 2 * radius;
            return `rotate(${x - 90}) translate(${y},0) rotate(${x < 180 ? 0 : 180})`;
        }


        var svgAsXML = (new XMLSerializer).serializeToString(svg.node());

        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = "white";
        var DOMURL = self.URL || self.webkitURL || self;
        var img = new Image();
        var svgData = new Blob([svgAsXML], {type: "image/svg+xml;charset=utf-8"});
        var url = DOMURL.createObjectURL(svgData);

        img.onload = function() {
            ctx.drawImage(img,0,0);
            var jpeg = canvas.toDataURL("image/jpeg");
            document.getElementById("catChart").value = jpeg;
        }
        img.src = url;

        var b64 = "data:image/svg+xml;base64," +window.btoa(svgAsXML);

        return svg.node();
    }


    function _data(FileAttachment){return(
        FileAttachment("flare-2.json").json()
    )}

    function _partition(d3){return(
        data => {
            const root = d3.hierarchy(data)
                .sum(d => d.value)
                .sort((a, b) => b.value - a.value);
            return d3.partition()
                .size([2 * Math.PI, root.height + 1])
                (root);
        }
    )}

    function _color(d3,data){return(
        d3.scaleOrdinal(d3.quantize(d3.interpolateRainbow, data.children.length + 1))
    )}

    function _format(d3){return(
        d3.format(",d")
    )}

    function _width(){return(
        932
    )}

    function _radius(width){return(
        width / 6
    )}

    function _arc(d3,radius){return(
        d3.arc()
            .startAngle(d => d.x0)
            .endAngle(d => d.x1)
            .padAngle(d => Math.min((d.x1 - d.x0) / 2, 0.005))
            .padRadius(radius * 1.5)
            .innerRadius(d => d.y0 * radius)
            .outerRadius(d => Math.max(d.y0 * radius, d.y1 * radius - 1))
    )}

    export default function define(runtime, observer) {
        const main = runtime.module();
        function toString() { return this.url; }
        const fileAttachments = new Map([
            // ["flare-2.json", {url: new URL("./files/result.json", import.meta.url), mimeType: "application/json", toString}]
            ["flare-2.json", {url: new URL("pdf_chart_record.php", import.meta.url), mimeType: "application/json", toString}]
        ]);
        main.builtin("FileAttachment", runtime.fileAttachments(name => fileAttachments.get(name)));
        // main.variable(observer()).define(["md"], _1);
        main.variable(observer("chart")).define("chart", ["partition","data","d3","width","color","arc","format","radius"], _chart);
        main.variable(observer).define("data", ["FileAttachment"], _data);
        main.variable(observer).define("partition", ["d3"], _partition);
        main.variable(observer).define("color", ["d3","data"], _color);
        main.variable(observer).define("format", ["d3"], _format);
        main.variable(observer).define("width", _width);
        main.variable(observer).define("radius", ["width"], _radius);
        main.variable(observer).define("arc", ["d3","radius"], _arc);
        return main;
    }

    function e(e,t,n){n=n||{};var r=e.ownerDocument,a=r.defaultView.CustomEvent;"function"==typeof a?a=new a(t,{detail:n}):((a=r.createEvent("Event")).initEvent(t,!1,!1),a.detail=n),e.dispatchEvent(a)}function t(e){return Array.isArray(e)||e instanceof Int8Array||e instanceof Int16Array||e instanceof Int32Array||e instanceof Uint8Array||e instanceof Uint8ClampedArray||e instanceof Uint16Array||e instanceof Uint32Array||e instanceof Float32Array||e instanceof Float64Array}function n(e){return e===(0|e)+""}function r(e){const t=document.createElement("span");return t.className="observablehq--cellname",t.textContent=`${e} = `,t}const a=Symbol.prototype.toString;function o(e){return a.call(e)}const{getOwnPropertySymbols:i,prototype:{hasOwnProperty:s}}=Object,{toStringTag:c}=Symbol,l={},u=i;function f(e,t){return s.call(e,t)}function d(e){return e[c]||e.constructor&&e.constructor.name||"Object"}function p(e,t){try{const n=e[t];return n&&n.constructor,n}catch(e){return l}}const h=[{symbol:"@@__IMMUTABLE_INDEXED__@@",name:"Indexed",modifier:!0},{symbol:"@@__IMMUTABLE_KEYED__@@",name:"Keyed",modifier:!0},{symbol:"@@__IMMUTABLE_LIST__@@",name:"List",arrayish:!0},{symbol:"@@__IMMUTABLE_MAP__@@",name:"Map"},{symbol:"@@__IMMUTABLE_ORDERED__@@",name:"Ordered",modifier:!0,prefix:!0},{symbol:"@@__IMMUTABLE_RECORD__@@",name:"Record"},{symbol:"@@__IMMUTABLE_SET__@@",name:"Set",arrayish:!0,setish:!0},{symbol:"@@__IMMUTABLE_STACK__@@",name:"Stack",arrayish:!0}];function m(e){try{let t=h.filter((({symbol:t})=>!0===e[t]));if(!t.length)return;const n=t.find((e=>!e.modifier)),r="Map"===n.name&&t.find((e=>e.modifier&&e.prefix)),a=t.some((e=>e.arrayish)),o=t.some((e=>e.setish));return{name:`${r?r.name:""}${n.name}`,symbols:t,arrayish:a&&!o,setish:o}}catch(e){return null}}const{getPrototypeOf:b,getOwnPropertyDescriptors:v}=Object,w=b({});function y(n,a,o,i){let s,c,l,u,f=t(n);n instanceof Map?n instanceof n.constructor?(s=`Map(${n.size})`,c=_):(s="Map()",c=T):n instanceof Set?n instanceof n.constructor?(s=`Set(${n.size})`,c=g):(s="Set()",c=T):f?(s=`${n.constructor.name}(${n.length})`,c=C):(u=m(n))?(s=`Immutable.${u.name}${"Record"===u.name?"":`(${n.size})`}`,f=u.arrayish,c=u.arrayish?x:u.setish?E:A):i?(s=d(n),c=N):(s=d(n),c=T);const p=document.createElement("span");p.className="observablehq--expanded",o&&p.appendChild(r(o));const h=p.appendChild(document.createElement("a"));h.innerHTML="<svg width=8 height=8 class='observablehq--caret'>\n    <path d='M4 7L0 1h8z' fill='currentColor' />\n  </svg>",h.appendChild(document.createTextNode(`${s}${f?" [":" {"}`)),h.addEventListener("mouseup",(function(e){e.stopPropagation(),ie(p,L(n,null,o,i))})),c=c(n);for(let e=0;!(l=c.next()).done&&e<20;++e)p.appendChild(l.value);if(!l.done){const t=p.appendChild(document.createElement("a"));t.className="observablehq--field",t.style.display="block",t.appendChild(document.createTextNode("  … more")),t.addEventListener("mouseup",(function(t){t.stopPropagation(),p.insertBefore(l.value,p.lastChild.previousSibling);for(let e=0;!(l=c.next()).done&&e<19;++e)p.insertBefore(l.value,p.lastChild.previousSibling);l.done&&p.removeChild(p.lastChild.previousSibling),e(p,"load")}))}return p.appendChild(document.createTextNode(f?"]":"}")),p}function*_(e){for(const[t,n]of e)yield q(t,n);yield*T(e)}function*g(e){for(const t of e)yield S(t);yield*T(e)}function*E(e){for(const t of e)yield S(t)}function*C(e){for(let t=0,n=e.length;t<n;++t)t in e&&(yield $(t,p(e,t),"observablehq--index"));for(const t in e)!n(t)&&f(e,t)&&(yield $(t,p(e,t),"observablehq--key"));for(const t of u(e))yield $(o(t),p(e,t),"observablehq--symbol")}function*x(e){let t=0;for(const n=e.size;t<n;++t)yield $(t,e.get(t),!0)}function*N(e){for(const t in v(e))yield $(t,p(e,t),"observablehq--key");for(const t of u(e))yield $(o(t),p(e,t),"observablehq--symbol");const t=b(e);t&&t!==w&&(yield j(t))}function*T(e){for(const t in e)f(e,t)&&(yield $(t,p(e,t),"observablehq--key"));for(const t of u(e))yield $(o(t),p(e,t),"observablehq--symbol");const t=b(e);t&&t!==w&&(yield j(t))}function*A(e){for(const[t,n]of e)yield $(t,n,"observablehq--key")}function j(e){const t=document.createElement("div"),n=t.appendChild(document.createElement("span"));return t.className="observablehq--field",n.className="observablehq--prototype-key",n.textContent="  <prototype>",t.appendChild(document.createTextNode(": ")),t.appendChild(oe(e,void 0,void 0,void 0,!0)),t}function $(e,t,n){const r=document.createElement("div"),a=r.appendChild(document.createElement("span"));return r.className="observablehq--field",a.className=n,a.textContent=`  ${e}`,r.appendChild(document.createTextNode(": ")),r.appendChild(oe(t)),r}function q(e,t){const n=document.createElement("div");return n.className="observablehq--field",n.appendChild(document.createTextNode("  ")),n.appendChild(oe(e)),n.appendChild(document.createTextNode(" => ")),n.appendChild(oe(t)),n}function S(e){const t=document.createElement("div");return t.className="observablehq--field",t.appendChild(document.createTextNode("  ")),t.appendChild(oe(e)),t}function O(e){const t=window.getSelection();return"Range"===t.type&&(t.containsNode(e,!0)||t.anchorNode.isSelfOrDescendant(e)||t.focusNode.isSelfOrDescendant(e))}function L(e,n,a,o){let i,s,c,l,u=t(e);if(e instanceof Map?e instanceof e.constructor?(i=`Map(${e.size})`,s=k):(i="Map()",s=U):e instanceof Set?e instanceof e.constructor?(i=`Set(${e.size})`,s=M):(i="Set()",s=U):u?(i=`${e.constructor.name}(${e.length})`,s=P):(l=m(e))?(i=`Immutable.${l.name}${"Record"===l.name?"":`(${e.size})`}`,u=l.arrayish,s=l.arrayish?I:l.setish?R:D):(i=d(e),s=U),n){const t=document.createElement("span");return t.className="observablehq--shallow",a&&t.appendChild(r(a)),t.appendChild(document.createTextNode(i)),t.addEventListener("mouseup",(function(n){O(t)||(n.stopPropagation(),ie(t,L(e)))})),t}const f=document.createElement("span");f.className="observablehq--collapsed",a&&f.appendChild(r(a));const p=f.appendChild(document.createElement("a"));p.innerHTML="<svg width=8 height=8 class='observablehq--caret'>\n    <path d='M7 4L1 8V0z' fill='currentColor' />\n  </svg>",p.appendChild(document.createTextNode(`${i}${u?" [":" {"}`)),f.addEventListener("mouseup",(function(t){O(f)||(t.stopPropagation(),ie(f,y(e,0,a,o)))}),!0),s=s(e);for(let e=0;!(c=s.next()).done&&e<20;++e)e>0&&f.appendChild(document.createTextNode(", ")),f.appendChild(c.value);return c.done||f.appendChild(document.createTextNode(", …")),f.appendChild(document.createTextNode(u?"]":"}")),f}function*k(e){for(const[t,n]of e)yield z(t,n);yield*U(e)}function*M(e){for(const t of e)yield oe(t,!0);yield*U(e)}function*R(e){for(const t of e)yield oe(t,!0)}function*I(e){let t=-1,n=0;for(const r=e.size;n<r;++n)n>t+1&&(yield F(n-t-1)),yield oe(e.get(n),!0),t=n;n>t+1&&(yield F(n-t-1))}function*P(e){let t=-1,r=0;for(const n=e.length;r<n;++r)r in e&&(r>t+1&&(yield F(r-t-1)),yield oe(p(e,r),!0),t=r);r>t+1&&(yield F(r-t-1));for(const t in e)!n(t)&&f(e,t)&&(yield B(t,p(e,t),"observablehq--key"));for(const t of u(e))yield B(o(t),p(e,t),"observablehq--symbol")}function*U(e){for(const t in e)f(e,t)&&(yield B(t,p(e,t),"observablehq--key"));for(const t of u(e))yield B(o(t),p(e,t),"observablehq--symbol")}function*D(e){for(const[t,n]of e)yield B(t,n,"observablehq--key")}function F(e){const t=document.createElement("span");return t.className="observablehq--empty",t.textContent=1===e?"empty":`empty × ${e}`,t}function B(e,t,n){const r=document.createDocumentFragment(),a=r.appendChild(document.createElement("span"));return a.className=n,a.textContent=e,r.appendChild(document.createTextNode(": ")),r.appendChild(oe(t,!0)),r}function z(e,t){const n=document.createDocumentFragment();return n.appendChild(oe(e,!0)),n.appendChild(document.createTextNode(" => ")),n.appendChild(oe(t,!0)),n}function W(e,t){if(e instanceof Date||(e=new Date(+e)),isNaN(e))return"function"==typeof t?t(e):t;const n=e.getUTCHours(),r=e.getUTCMinutes(),a=e.getUTCSeconds(),o=e.getUTCMilliseconds();return`${i=e.getUTCFullYear(),i<0?`-${H(-i,6)}`:i>9999?`+${H(i,6)}`:H(i,4)}-${H(e.getUTCMonth()+1,2)}-${H(e.getUTCDate(),2)}${n||r||a||o?`T${H(n,2)}:${H(r,2)}${a||o?`:${H(a,2)}${o?`.${H(o,3)}`:""}`:""}Z`:""}`;var i}function H(e,t){return`${e}`.padStart(t,"0")}var V=Error.prototype.toString;var G=RegExp.prototype.toString;function Y(e){return e.replace(/[\\`\x00-\x09\x0b-\x19]|\${/g,Z)}function Z(e){var t=e.charCodeAt(0);switch(t){case 8:return"\\b";case 9:return"\\t";case 11:return"\\v";case 12:return"\\f";case 13:return"\\r"}return t<16?"\\x0"+t.toString(16):t<32?"\\x"+t.toString(16):"\\"+e}function J(e,t){for(var n=0;t.exec(e);)++n;return n}var K=Function.prototype.toString,X={prefix:"async ƒ"},Q={prefix:"async ƒ*"},ee={prefix:"class"},te={prefix:"ƒ"},ne={prefix:"ƒ*"};function re(e,t,n){var a=document.createElement("span");a.className="observablehq--function",n&&a.appendChild(r(n));var o=a.appendChild(document.createElement("span"));return o.className="observablehq--keyword",o.textContent=e.prefix,a.appendChild(document.createTextNode(t)),a}const{prototype:{toString:ae}}=Object;function oe(e,t,n,a,i){let s=typeof e;switch(s){case"boolean":case"undefined":e+="";break;case"number":e=0===e&&1/e<0?"-0":e+"";break;case"bigint":e+="n";break;case"symbol":e=o(e);break;case"function":return function(e,t){var n,r,a=K.call(e);switch(e.constructor&&e.constructor.name){case"AsyncFunction":n=X;break;case"AsyncGeneratorFunction":n=Q;break;case"GeneratorFunction":n=ne;break;default:n=/^class\b/.test(a)?ee:te}return n===ee?re(n,"",t):(r=/^(?:async\s*)?(\w+)\s*=>/.exec(a))?re(n,"("+r[1]+")",t):(r=/^(?:async\s*)?\(\s*(\w+(?:\s*,\s*\w+)*)?\s*\)/.exec(a))||(r=/^(?:async\s*)?function(?:\s*\*)?(?:\s*\w+)?\s*\(\s*(\w+(?:\s*,\s*\w+)*)?\s*\)/.exec(a))?re(n,r[1]?"("+r[1].replace(/\s*,\s*/g,", ")+")":"()",t):re(n,"(…)",t)}(e,a);case"string":return function(e,t,n,a){if(!1===t){if(J(e,/["\n]/g)<=J(e,/`|\${/g)){const t=document.createElement("span");a&&t.appendChild(r(a));const n=t.appendChild(document.createElement("span"));return n.className="observablehq--string",n.textContent=JSON.stringify(e),t}const o=e.split("\n");if(o.length>20&&!n){const n=document.createElement("div");a&&n.appendChild(r(a));const i=n.appendChild(document.createElement("span"));i.className="observablehq--string",i.textContent="`"+Y(o.slice(0,20).join("\n"));const s=n.appendChild(document.createElement("span")),c=o.length-20;return s.textContent=`Show ${c} truncated line${c>1?"s":""}`,s.className="observablehq--string-expand",s.addEventListener("mouseup",(function(r){r.stopPropagation(),ie(n,oe(e,t,!0,a))})),n}const i=document.createElement("span");a&&i.appendChild(r(a));const s=i.appendChild(document.createElement("span"));return s.className="observablehq--string"+(n?" observablehq--expanded":""),s.textContent="`"+Y(e)+"`",i}const o=document.createElement("span");a&&o.appendChild(r(a));const i=o.appendChild(document.createElement("span"));return i.className="observablehq--string",i.textContent=JSON.stringify(e.length>100?`${e.slice(0,50)}…${e.slice(-49)}`:e),o}(e,t,n,a);default:if(null===e){s=null,e="null";break}if(e instanceof Date){s="date",e=W(e,"Invalid Date");break}if(e===l){s="forbidden",e="[forbidden]";break}switch(ae.call(e)){case"[object RegExp]":s="regexp",e=function(e){return G.call(e)}(e);break;case"[object Error]":case"[object DOMException]":s="error",e=function(e){return e.stack||V.call(e)}(e);break;default:return(n?y:L)(e,t,a,i)}}const c=document.createElement("span");a&&c.appendChild(r(a));const u=c.appendChild(document.createElement("span"));return u.className=`observablehq--${s}`,u.textContent=e,c}function ie(t,n){t.classList.contains("observablehq--inspect")&&n.classList.add("observablehq--inspect"),t.parentNode.replaceChild(n,t),e(n,"load")}const se=/\s+\(\d+:\d+\)$/m;class Inspector{constructor(e){if(!e)throw new Error("invalid node");this._node=e,e.classList.add("observablehq")}pending(){const{_node:e}=this;e.classList.remove("observablehq--error"),e.classList.add("observablehq--running")}fulfilled(t,n){const{_node:r}=this;if((!function(e){return(e instanceof Element||e instanceof Text)&&e instanceof e.constructor}(t)||t.parentNode&&t.parentNode!==r)&&(t=oe(t,!1,r.firstChild&&r.firstChild.classList&&r.firstChild.classList.contains("observablehq--expanded"),n)).classList.add("observablehq--inspect"),r.classList.remove("observablehq--running","observablehq--error"),r.firstChild!==t)if(r.firstChild){for(;r.lastChild!==r.firstChild;)r.removeChild(r.lastChild);r.replaceChild(t,r.firstChild)}else r.appendChild(t);e(r,"update")}rejected(t,n){const{_node:a}=this;for(a.classList.remove("observablehq--running"),a.classList.add("observablehq--error");a.lastChild;)a.removeChild(a.lastChild);var o=document.createElement("div");o.className="observablehq--inspect",n&&o.appendChild(r(n)),o.appendChild(document.createTextNode((t+"").replace(se,""))),a.appendChild(o),e(a,"error",{error:t})}}Inspector.into=function(e){if("string"==typeof e&&null==(e=document.querySelector(e)))throw new Error("container not found");return function(){return new Inspector(e.appendChild(document.createElement("div")))}};var ce={},le={};function ue(e){return new Function("d","return {"+e.map((function(e,t){return JSON.stringify(e)+": d["+t+'] || ""'})).join(",")+"}")}function fe(e){var t=Object.create(null),n=[];return e.forEach((function(e){for(var r in e)r in t||n.push(t[r]=r)})),n}function de(e,t){var n=e+"",r=n.length;return r<t?new Array(t-r+1).join(0)+n:n}function pe(e){var t,n=e.getUTCHours(),r=e.getUTCMinutes(),a=e.getUTCSeconds(),o=e.getUTCMilliseconds();return isNaN(e)?"Invalid Date":((t=e.getUTCFullYear())<0?"-"+de(-t,6):t>9999?"+"+de(t,6):de(t,4))+"-"+de(e.getUTCMonth()+1,2)+"-"+de(e.getUTCDate(),2)+(o?"T"+de(n,2)+":"+de(r,2)+":"+de(a,2)+"."+de(o,3)+"Z":a?"T"+de(n,2)+":"+de(r,2)+":"+de(a,2)+"Z":r||n?"T"+de(n,2)+":"+de(r,2)+"Z":"")}function he(e){var t=new RegExp('["'+e+"\n\r]"),n=e.charCodeAt(0);function r(e,t){var r,a=[],o=e.length,i=0,s=0,c=o<=0,l=!1;function u(){if(c)return le;if(l)return l=!1,ce;var t,r,a=i;if(34===e.charCodeAt(a)){for(;i++<o&&34!==e.charCodeAt(i)||34===e.charCodeAt(++i););return(t=i)>=o?c=!0:10===(r=e.charCodeAt(i++))?l=!0:13===r&&(l=!0,10===e.charCodeAt(i)&&++i),e.slice(a+1,t-1).replace(/""/g,'"')}for(;i<o;){if(10===(r=e.charCodeAt(t=i++)))l=!0;else if(13===r)l=!0,10===e.charCodeAt(i)&&++i;else if(r!==n)continue;return e.slice(a,t)}return c=!0,e.slice(a,o)}for(10===e.charCodeAt(o-1)&&--o,13===e.charCodeAt(o-1)&&--o;(r=u())!==le;){for(var f=[];r!==ce&&r!==le;)f.push(r),r=u();t&&null==(f=t(f,s++))||a.push(f)}return a}function a(t,n){return t.map((function(t){return n.map((function(e){return i(t[e])})).join(e)}))}function o(t){return t.map(i).join(e)}function i(e){return null==e?"":e instanceof Date?pe(e):t.test(e+="")?'"'+e.replace(/"/g,'""')+'"':e}return{parse:function(e,t){var n,a,o=r(e,(function(e,r){if(n)return n(e,r-1);a=e,n=t?function(e,t){var n=ue(e);return function(r,a){return t(n(r),a,e)}}(e,t):ue(e)}));return o.columns=a||[],o},parseRows:r,format:function(t,n){return null==n&&(n=fe(t)),[n.map(i).join(e)].concat(a(t,n)).join("\n")},formatBody:function(e,t){return null==t&&(t=fe(e)),a(e,t).join("\n")},formatRows:function(e){return e.map(o).join("\n")},formatRow:o,formatValue:i}}var me=he(","),be=me.parse,ve=me.parseRows,we=he("\t"),ye=we.parse,_e=we.parseRows;function ge(e){for(var t in e){var n,r,a=e[t].trim();if(a)if("true"===a)a=!0;else if("false"===a)a=!1;else if("NaN"===a)a=NaN;else if(isNaN(n=+a)){if(!(r=a.match(/^([-+]\d{2})?\d{4}(-\d{2}(-\d{2})?)?(T\d{2}:\d{2}(:\d{2}(\.\d{3})?)?(Z|[-+]\d{2}:\d{2})?)?$/)))continue;Ee&&r[4]&&!r[7]&&(a=a.replace(/-/g,"/").replace(/T/," ")),a=new Date(a)}else a=n;else a=null;e[t]=a}return e}const Ee=new Date("2019-01-01T00:00").getHours()||new Date("2019-07-01T00:00").getHours();function Ce(e,t,n){return{resolve:(r=n)=>`${e}@${t}/${r}`}}const xe=Ce("d3","7.8.2","dist/d3.min.js"),Ne=Ce("@observablehq/inputs","0.10.4","dist/inputs.min.js"),Te=Ce("@observablehq/plot","0.6.2","dist/plot.umd.min.js"),Ae=Ce("@observablehq/graphviz","0.2.1","dist/graphviz.min.js"),je=Ce("@observablehq/highlight.js","2.0.0","highlight.min.js"),$e=Ce("@observablehq/katex","0.11.1","dist/katex.min.js"),qe=Ce("lodash","4.17.21","lodash.min.js"),Se=Ce("htl","0.3.1","dist/htl.min.js"),Oe=Ce("jszip","3.10.1","dist/jszip.min.js"),Le=Ce("marked","0.3.12","marked.min.js"),ke=Ce("sql.js","1.8.0","dist/sql-wasm.js"),Me=Ce("vega","5.22.1","build/vega.min.js"),Re=Ce("vega-lite","5.6.0","build/vega-lite.min.js"),Ie=Ce("vega-lite-api","5.0.0","build/vega-lite-api.min.js"),Pe=Ce("apache-arrow","4.0.1","Arrow.es2015.min.js"),Ue=Ce("apache-arrow","9.0.0","+esm"),De=Ce("arquero","4.8.8","dist/arquero.min.js"),Fe=Ce("topojson-client","3.1.0","dist/topojson-client.min.js"),Be=Ce("exceljs","4.3.0","dist/exceljs.min.js"),ze=Ce("mermaid","9.2.2","dist/mermaid.min.js"),We=Ce("leaflet","1.9.3","dist/leaflet.js"),He=Ce("@duckdb/duckdb-wasm","1.17.0","+esm"),Ve=new Map,Ge=[],Ye=Ge.map,Ze=Ge.some,Je=Ge.hasOwnProperty,Ke=/^((?:@[^/@]+\/)?[^/@]+)(?:@([^/]+))?(?:\/(.*))?$/,Xe=/^\d+\.\d+\.\d+(-[\w-.+]+)?$/,Qe=/(?:\.[^/]*|\/)$/;class RequireError extends Error{constructor(e){super(e)}}function et(e){const t=Ke.exec(e);return t&&{name:t[1],version:t[2],path:t[3]}}function tt(e="https://cdn.jsdelivr.net/npm/",t=["unpkg","jsdelivr","browser","main"]){if(!/\/$/.test(e))throw new Error("origin lacks trailing slash");function n(t){const n=`${e}${t.name}${t.version?`@${t.version}`:""}/package.json`;let r=Ve.get(n);return r||Ve.set(n,r=fetch(n).then((e=>{if(!e.ok)throw new RequireError("unable to load package.json");return e.redirected&&!Ve.has(e.url)&&Ve.set(e.url,r),e.json()}))),r}return async function(r,a){if(r.startsWith(e)&&(r=r.substring(e.length)),/^(\w+:)|\/\//i.test(r))return r;if(/^[.]{0,2}\//i.test(r))return new URL(r,null==a?location:a).href;if(!r.length||/^[\s._]/.test(r)||/\s$/.test(r))throw new RequireError("illegal name");const o=et(r);if(!o)return`${e}${r}`;if(!o.version&&null!=a&&a.startsWith(e)){const t=await n(et(a.substring(e.length)));o.version=t.dependencies&&t.dependencies[o.name]||t.peerDependencies&&t.peerDependencies[o.name]}if(o.path&&!Qe.test(o.path)&&(o.path+=".js"),o.path&&o.version&&Xe.test(o.version))return`${e}${o.name}@${o.version}/${o.path}`;const i=await n(o);return`${e}${i.name}@${i.version}/${o.path||function(e){for(const n of t){let t=e[n];if("string"==typeof t)return t.startsWith("./")&&(t=t.slice(2)),Qe.test(t)?t:`${t}.js`}}(i)||"index.js"}`}}RequireError.prototype.name=RequireError.name;var nt=rt(tt());function rt(e){const t=new Map,n=a(null);function r(e){if("string"!=typeof e)return e;let n=t.get(e);return n||t.set(e,n=new Promise(((t,n)=>{const r=document.createElement("script");r.onload=()=>{try{t(Ge.pop()(a(e)))}catch(e){n(new RequireError("invalid module"))}r.remove()},r.onerror=()=>{n(new RequireError("unable to load module")),r.remove()},r.async=!0,r.src=e,window.define=st,document.head.appendChild(r)}))),n}function a(t){return n=>Promise.resolve(e(n,t)).then(r)}function o(e){return arguments.length>1?Promise.all(Ye.call(arguments,n)).then(at):n(e)}return o.alias=function(t){return rt(((n,r)=>n in t&&(r=null,"string"!=typeof(n=t[n]))?n:e(n,r)))},o.resolve=e,o}function at(e){const t={};for(const n of e)for(const e in n)Je.call(n,e)&&(null==n[e]?Object.defineProperty(t,e,{get:ot(n,e)}):t[e]=n[e]);return t}function ot(e,t){return()=>e[t]}function it(e){return"exports"===(e+="")||"module"===e}function st(e,t,n){const r=arguments.length;r<2?(n=e,t=[]):r<3&&(n=t,t="string"==typeof e?[]:e),Ge.push(Ze.call(t,it)?e=>{const r={},a={exports:r};return Promise.all(Ye.call(t,(t=>"exports"===(t+="")?r:"module"===t?a:e(t)))).then((e=>(n.apply(null,e),a.exports)))}:e=>Promise.all(Ye.call(t,e)).then((e=>"function"==typeof n?n.apply(null,e):n)))}st.amd={};const ct="https://cdn.observableusercontent.com/npm/";let lt=nt;async function ut(e){const[t,n]=await Promise.all([e(ke.resolve()),e.resolve(ke.resolve("dist/"))]);return t({locateFile:e=>`${n}${e}`})}class SQLiteDatabaseClient{constructor(e){Object.defineProperties(this,{_db:{value:e}})}static async open(e){const[t,n]=await Promise.all([ut(lt),Promise.resolve(e).then(dt)]);return new SQLiteDatabaseClient(new t.Database(n))}async query(e,t){return await async function(e,t,n){const[r]=await e.exec(t,n);if(!r)return[];const{columns:a,values:o}=r,i=o.map((e=>Object.fromEntries(e.map(((e,t)=>[a[t],e])))));return i.columns=a,i}(this._db,e,t)}async queryRow(e,t){return(await this.query(e,t))[0]||null}async explain(e,t){return pt("pre",{className:"observablehq--inspect"},[ht((await this.query(`EXPLAIN QUERY PLAN ${e}`,t)).map((e=>e.detail)).join("\n"))])}async describeTables({schema:e}={}){return this.query(`SELECT NULLIF(schema, 'main') AS schema, name FROM pragma_table_list() WHERE type = 'table'${null==e?"":" AND schema = ?"} AND name NOT LIKE 'sqlite_%' ORDER BY schema, name`,null==e?[]:[e])}async describeColumns({schema:e,table:t}={}){if(null==t)throw new Error("missing table");const n=await this.query(`SELECT name, type, "notnull" FROM pragma_table_info(?${null==e?"":", ?"}) ORDER BY cid`,null==e?[t]:[t,e]);if(!n.length)throw new Error(`table not found: ${t}`);return n.map((({name:e,type:t,notnull:n})=>({name:e,type:ft(t),databaseType:t,nullable:!n})))}async describe(e){const t=await(void 0===e?this.query("SELECT name FROM sqlite_master WHERE type = 'table'"):this.query("SELECT * FROM pragma_table_info(?)",[e]));if(!t.length)throw new Error("Not found");const{columns:n}=t;return pt("table",{value:t},[pt("thead",[pt("tr",n.map((e=>pt("th",[ht(e)]))))]),pt("tbody",t.map((e=>pt("tr",n.map((t=>pt("td",[ht(e[t])])))))))])}async sql(){return this.query(...this.queryTag.apply(this,arguments))}queryTag(e,...t){return[e.join("?"),t]}}function ft(e){switch(e){case"NULL":return"null";case"INT":case"INTEGER":case"TINYINT":case"SMALLINT":case"MEDIUMINT":case"BIGINT":case"UNSIGNED BIG INT":case"INT2":case"INT8":return"integer";case"TEXT":case"CLOB":case"DATE":case"DATETIME":return"string";case"REAL":case"DOUBLE":case"DOUBLE PRECISION":case"FLOAT":case"NUMERIC":return"number";case"BLOB":return"buffer";default:return/^(?:(?:(?:VARYING|NATIVE) )?CHARACTER|(?:N|VAR|NVAR)CHAR)\(/.test(e)?"string":/^(?:DECIMAL|NUMERIC)\(/.test(e)?"number":"other"}}function dt(e){return"string"==typeof e?fetch(e).then(dt):e instanceof Response||e instanceof Blob?e.arrayBuffer().then(dt):e instanceof ArrayBuffer?new Uint8Array(e):e}function pt(e,t,n){2===arguments.length&&(n=t,t=void 0);const r=document.createElement(e);if(void 0!==t)for(const e in t)r[e]=t[e];if(void 0!==n)for(const e of n)r.appendChild(e);return r}function ht(e){return document.createTextNode(e)}Object.defineProperty(SQLiteDatabaseClient.prototype,"dialect",{value:"sqlite"});class Workbook{constructor(e){Object.defineProperties(this,{_:{value:e},sheetNames:{value:e.worksheets.map((e=>e.name)),enumerable:!0}})}sheet(e,t){const n="number"==typeof e?this.sheetNames[e]:this.sheetNames.includes(e+="")?e:null;if(null==n)throw new Error(`Sheet not found: ${e}`);return function(e,{range:t,headers:n}={}){let[[r,a],[o,i]]=function(e=":",{columnCount:t,rowCount:n}){if(!(e+="").match(/^[A-Z]*\d*:[A-Z]*\d*$/))throw new Error("Malformed range specifier");const[[r=0,a=0],[o=t-1,i=n-1]]=e.split(":").map(wt);return[[r,a],[o,i]]}(t,e);const s=n?e._rows[a++]:null;let c=new Set(["#"]);for(let e=r;e<=o;e++){const t=s?mt(s.findCell(e+1)):null;let n=t&&t+""||vt(e);for(;c.has(n);)n+="_";c.add(n)}c=new Array(r).concat(Array.from(c));const l=new Array(i-a+1);for(let t=a;t<=i;t++){const n=l[t-a]=Object.create(null,{"#":{value:t+1}}),i=e.getRow(t+1);if(i.hasValues)for(let e=r;e<=o;e++){const t=mt(i.findCell(e+1));null!=t&&(n[c[e+1]]=t)}}return l.columns=c.filter((()=>!0)),l}(this._.getWorksheet(n),t)}}function mt(e){if(!e)return;const{value:t}=e;if(t&&"object"==typeof t&&!(t instanceof Date)){if(t.formula||t.sharedFormula)return t.result&&t.result.error?NaN:t.result;if(t.richText)return bt(t);if(t.text){let{text:e}=t;return e.richText&&(e=bt(e)),t.hyperlink&&t.hyperlink!==e?`${t.hyperlink} ${e}`:e}return t}return t}function bt(e){return e.richText.map((e=>e.text)).join("")}function vt(e){let t="";e++;do{t=String.fromCharCode(64+(e%26||26))+t}while(e=Math.floor((e-1)/26));return t}function wt(e){const[,t,n]=e.match(/^([A-Z]*)(\d*)$/);let r=0;if(t)for(let e=0;e<t.length;e++)r+=Math.pow(26,t.length-e-1)*(t.charCodeAt(e)-64);return[r?r-1:void 0,n?+n-1:void 0]}async function yt(e){const t=await fetch(await e.url());if(!t.ok)throw new Error(`Unable to load file: ${e.name}`);return t}async function _t(e,t,{array:n=!1,typed:r=!1}={}){const a=await e.text();return("\t"===t?n?_e:ye:n?ve:be)(a,r&&ge)}class gt{constructor(e,t){Object.defineProperty(this,"name",{value:e,enumerable:!0}),void 0!==t&&Object.defineProperty(this,"mimeType",{value:t+"",enumerable:!0})}async blob(){return(await yt(this)).blob()}async arrayBuffer(){return(await yt(this)).arrayBuffer()}async text(){return(await yt(this)).text()}async json(){return(await yt(this)).json()}async stream(){return(await yt(this)).body}async csv(e){return _t(this,",",e)}async tsv(e){return _t(this,"\t",e)}async image(e){const t=await this.url();return new Promise(((n,r)=>{const a=new Image;new URL(t,document.baseURI).origin!==new URL(location).origin&&(a.crossOrigin="anonymous"),Object.assign(a,e),a.onload=()=>n(a),a.onerror=()=>r(new Error(`Unable to load file: ${this.name}`)),a.src=t}))}async arrow({version:e=4}={}){switch(e){case 4:{const[e,t]=await Promise.all([lt(Pe.resolve()),yt(this)]);return e.Table.from(t)}case 9:{const[e,t]=await Promise.all([import(`${ct}${Ue.resolve()}`),yt(this)]);return e.tableFromIPC(t)}default:throw new Error(`unsupported arrow version: ${e}`)}}async sqlite(){return SQLiteDatabaseClient.open(yt(this))}async zip(){const[e,t]=await Promise.all([lt(Oe.resolve()),this.arrayBuffer()]);return new ZipArchive(await e.loadAsync(t))}async xml(e="application/xml"){return(new DOMParser).parseFromString(await this.text(),e)}async html(){return this.xml("text/html")}async xlsx(){const[e,t]=await Promise.all([lt(Be.resolve()),this.arrayBuffer()]);return new Workbook(await(new e.Workbook).xlsx.load(t))}}class FileAttachment extends gt{constructor(e,t,n){super(t,n),Object.defineProperty(this,"_url",{value:e})}async url(){return await this._url+""}}function Et(e){throw new Error(`File not found: ${e}`)}class ZipArchive{constructor(e){Object.defineProperty(this,"_",{value:e}),this.filenames=Object.keys(e.files).filter((t=>!e.files[t].dir))}file(e){const t=this._.file(e+="");if(!t||t.dir)throw new Error(`file not found: ${e}`);return new ZipArchiveEntry(t)}}class ZipArchiveEntry extends gt{constructor(e){super(e.name),Object.defineProperty(this,"_",{value:e}),Object.defineProperty(this,"_url",{writable:!0})}async url(){return this._url||(this._url=this.blob().then(URL.createObjectURL))}async blob(){return this._.async("blob")}async arrayBuffer(){return this._.async("arraybuffer")}async text(){return this._.async("text")}async json(){return JSON.parse(await this.text())}}var Ct={math:"http://www.w3.org/1998/Math/MathML",svg:"http://www.w3.org/2000/svg",xhtml:"http://www.w3.org/1999/xhtml",xlink:"http://www.w3.org/1999/xlink",xml:"http://www.w3.org/XML/1998/namespace",xmlns:"http://www.w3.org/2000/xmlns/"};var xt=0;function Nt(e){return new Tt("O-"+(null==e?"":e+"-")+ ++xt)}function Tt(e){this.id=e,this.href=new URL(`#${e}`,location)+""}Tt.prototype.toString=function(){return"url("+this.href+")"};var At=Object.freeze({__proto__:null,canvas:function(e,t){var n=document.createElement("canvas");return n.width=e,n.height=t,n},context2d:function(e,t,n){null==n&&(n=devicePixelRatio);var r=document.createElement("canvas");r.width=e*n,r.height=t*n,r.style.width=e+"px";var a=r.getContext("2d");return a.scale(n,n),a},download:function(e,t="untitled",n="Save"){const r=document.createElement("a"),a=r.appendChild(document.createElement("button"));async function o(){await new Promise(requestAnimationFrame),URL.revokeObjectURL(r.href),r.removeAttribute("href"),a.textContent=n,a.disabled=!1}return a.textContent=n,r.download=t,r.onclick=async t=>{if(a.disabled=!0,r.href)return o();a.textContent="Saving…";try{const t=await("function"==typeof e?e():e);a.textContent="Download",r.href=URL.createObjectURL(t)}catch(e){a.textContent=n}if(t.eventPhase)return o();a.disabled=!1},r},element:function(e,t){var n,r=e+="",a=r.indexOf(":");a>=0&&"xmlns"!==(r=e.slice(0,a))&&(e=e.slice(a+1));var o=Ct.hasOwnProperty(r)?document.createElementNS(Ct[r],e):document.createElement(e);if(t)for(var i in t)a=(r=i).indexOf(":"),n=t[i],a>=0&&"xmlns"!==(r=i.slice(0,a))&&(i=i.slice(a+1)),Ct.hasOwnProperty(r)?o.setAttributeNS(Ct[r],i,n):o.setAttribute(i,n);return o},input:function(e){var t=document.createElement("input");return null!=e&&(t.type=e),t},range:function(e,t,n){1===arguments.length&&(t=e,e=null);var r=document.createElement("input");return r.min=e=null==e?0:+e,r.max=t=null==t?1:+t,r.step=null==n?"any":n=+n,r.type="range",r},select:function(e){var t=document.createElement("select");return Array.prototype.forEach.call(e,(function(e){var n=document.createElement("option");n.value=n.textContent=e,t.appendChild(n)})),t},svg:function(e,t){var n=document.createElementNS("http://www.w3.org/2000/svg","svg");return n.setAttribute("viewBox",[0,0,e,t]),n.setAttribute("width",e),n.setAttribute("height",t),n},text:function(e){return document.createTextNode(e)},uid:Nt});var jt=Object.freeze({__proto__:null,buffer:function(e){return new Promise((function(t,n){var r=new FileReader;r.onload=function(){t(r.result)},r.onerror=n,r.readAsArrayBuffer(e)}))},text:function(e){return new Promise((function(t,n){var r=new FileReader;r.onload=function(){t(r.result)},r.onerror=n,r.readAsText(e)}))},url:function(e){return new Promise((function(t,n){var r=new FileReader;r.onload=function(){t(r.result)},r.onerror=n,r.readAsDataURL(e)}))}});function $t(){return this}function qt(e,t){let n=!1;if("function"!=typeof t)throw new Error("dispose is not a function");return{[Symbol.iterator]:$t,next:()=>n?{done:!0}:(n=!0,{done:!1,value:e}),return:()=>(n=!0,t(e),{done:!0}),throw:()=>({done:n=!0})}}function St(e){let t,n,r=!1;const a=e((function(e){n?(n(e),n=null):r=!0;return t=e}));if(null!=a&&"function"!=typeof a)throw new Error("function"==typeof a.then?"async initializers are not supported":"initializer returned something, but not a dispose function");return{[Symbol.iterator]:$t,throw:()=>({done:!0}),return:()=>(null!=a&&a(),{done:!0}),next:function(){return{done:!1,value:r?(r=!1,Promise.resolve(t)):new Promise((e=>n=e))}}}}function Ot(e){switch(e.type){case"range":case"number":return e.valueAsNumber;case"date":return e.valueAsDate;case"checkbox":return e.checked;case"file":return e.multiple?e.files:e.files[0];case"select-multiple":return Array.from(e.selectedOptions,(e=>e.value));default:return e.value}}var Lt=Object.freeze({__proto__:null,disposable:qt,filter:function*(e,t){for(var n,r=-1;!(n=e.next()).done;)t(n.value,++r)&&(yield n.value)},input:function(e){return St((function(t){var n=function(e){switch(e.type){case"button":case"submit":case"checkbox":return"click";case"file":return"change";default:return"input"}}(e),r=Ot(e);function a(){t(Ot(e))}return e.addEventListener(n,a),void 0!==r&&t(r),function(){e.removeEventListener(n,a)}}))},map:function*(e,t){for(var n,r=-1;!(n=e.next()).done;)yield t(n.value,++r)},observe:St,queue:function(e){let t;const n=[],r=e((function(e){n.push(e),t&&(t(n.shift()),t=null);return e}));if(null!=r&&"function"!=typeof r)throw new Error("function"==typeof r.then?"async initializers are not supported":"initializer returned something, but not a dispose function");return{[Symbol.iterator]:$t,throw:()=>({done:!0}),return:()=>(null!=r&&r(),{done:!0}),next:function(){return{done:!1,value:n.length?Promise.resolve(n.shift()):new Promise((e=>t=e))}}}},range:function*(e,t,n){e=+e,t=+t,n=(a=arguments.length)<2?(t=e,e=0,1):a<3?1:+n;for(var r=-1,a=0|Math.max(0,Math.ceil((t-e)/n));++r<a;)yield e+r*n},valueAt:function(e,t){if(!(!isFinite(t=+t)||t<0||t!=t|0))for(var n,r=-1;!(n=e.next()).done;)if(++r===t)return n.value},worker:function(e){const t=URL.createObjectURL(new Blob([e],{type:"text/javascript"})),n=new Worker(t);return qt(n,(()=>{n.terminate(),URL.revokeObjectURL(t)}))}});function kt(e){return e&&"function"==typeof e.toArrowBuffer}function Mt(e){return e&&"function"==typeof e.getChild&&"function"==typeof e.toArray&&e.schema&&Array.isArray(e.schema.fields)}function Rt(e){return{name:e.name,type:It(e.type),nullable:e.nullable,databaseType:String(e.type)}}function It(e){switch(e.typeId){case 2:return"integer";case 3:case 7:return"number";case 4:case 15:return"buffer";case 5:return"string";case 6:return"boolean";case 8:case 9:case 10:return"date";case 12:case 16:return"array";case 13:case 14:return"object";default:return"other"}}async function Pt(){return await import(`${ct}${Ue.resolve()}`)}class DuckDBClient{constructor(e){Object.defineProperties(this,{_db:{value:e}})}async queryStream(e,t){const n=await this._db.connect();let r,a;try{if(t?.length>0){const a=await n.prepare(e);r=await a.send(...t)}else r=await n.send(e);if(a=await r.next(),a.done)throw new Error("missing first batch")}catch(e){throw await n.close(),e}return{schema:(o=a.value,o.schema.fields.map(Rt)),async*readRows(){try{for(;!a.done;)yield a.value.toArray(),a=await r.next()}finally{await n.close()}}};var o}async query(e,t){const n=await this.queryStream(e,t),r=[];for await(const e of n.readRows())for(const t of e)r.push(t);return r.schema=n.schema,r}async queryRow(e,t){const n=(await this.queryStream(e,t)).readRows();try{const{done:e,value:t}=await n.next();return e||!t.length?null:t[0]}finally{await n.return()}}async sql(e,...t){return await this.query(e.join("?"),t)}queryTag(e,...t){return[e.join("?"),t]}escape(e){return`"${e}"`}async describeTables(){return(await this.query("SHOW TABLES")).map((({name:e})=>({name:e})))}async describeColumns({table:e}={}){return(await this.query(`DESCRIBE ${this.escape(e)}`)).map((({column_name:e,column_type:t,null:n})=>({name:e,type:Bt(t),nullable:"NO"!==n,databaseType:t})))}static async of(e={},t={}){const n=await async function(){const e=await import(`${ct}${He.resolve()}`),t=await e.selectBundle({mvp:{mainModule:`${ct}${He.resolve("dist/duckdb-mvp.wasm")}`,mainWorker:`${ct}${He.resolve("dist/duckdb-browser-mvp.worker.js")}`},eh:{mainModule:`${ct}${He.resolve("dist/duckdb-eh.wasm")}`,mainWorker:`${ct}${He.resolve("dist/duckdb-browser-eh.worker.js")}`}}),n=new e.ConsoleLogger,r=await e.createWorker(t.mainWorker),a=new e.AsyncDuckDB(n,r);return await a.instantiate(t.mainModule),a}();return void 0===t.query?.castTimestampToDate&&(t={...t,query:{...t.query,castTimestampToDate:!0}}),await n.open(t),await Promise.all(Object.entries(e).map((async([e,t])=>{if(t instanceof FileAttachment)await Ut(n,e,t);else if(Mt(t))await Dt(n,e,t);else if(Array.isArray(t))await Ft(n,e,t);else if(kt(t))await async function(e,t,n){const r=(await Pt()).tableFromIPC(n.toArrowBuffer());return await Dt(e,t,r)}(n,e,t);else if("data"in t){const{data:r,...a}=t;Mt(r)?await Dt(n,e,r,a):await Ft(n,e,r,a)}else{if(!("file"in t))throw new Error(`invalid source: ${t}`);{const{file:r,...a}=t;await Ut(n,e,r,a)}}}))),new DuckDBClient(n)}}async function Ut(e,t,n,r){const a=await n.url();if(a.startsWith("blob:")){const t=await n.arrayBuffer();await e.registerFileBuffer(n.name,new Uint8Array(t))}else await e.registerFileURL(n.name,a);const o=await e.connect();try{switch(n.mimeType){case"text/csv":case"text/tab-separated-values":return await o.insertCSVFromPath(n.name,{name:t,schema:"main",...r}).catch((async e=>{if(e.toString().includes("Could not convert"))return await async function(e,t,n){const r=await e.prepare(`CREATE TABLE '${n}' AS SELECT * FROM read_csv_auto(?, ALL_VARCHAR=TRUE)`);return await r.send(t.name)}(o,n,t)}));case"application/json":return await o.insertJSONFromPath(n.name,{name:t,schema:"main",...r});default:if(/\.arrow$/i.test(n.name)){const e=new Uint8Array(await n.arrayBuffer());return await o.insertArrowFromIPCStream(e,{name:t,schema:"main",...r})}if(/\.parquet$/i.test(n.name))return await o.query(`CREATE VIEW '${t}' AS SELECT * FROM parquet_scan('${n.name}')`);throw new Error(`unknown file type: ${n.mimeType}`)}}finally{await o.close()}}async function Dt(e,t,n,r){const a=await e.connect();try{await a.insertArrowTable(n,{name:t,schema:"main",...r})}finally{await a.close()}}async function Ft(e,t,n,r){const a=(await Pt()).tableFromJSON(n);return await Dt(e,t,a,r)}function Bt(e){switch(e){case"BIGINT":case"HUGEINT":case"UBIGINT":return"bigint";case"DOUBLE":case"REAL":case"FLOAT":return"number";case"INTEGER":case"SMALLINT":case"TINYINT":case"USMALLINT":case"UINTEGER":case"UTINYINT":return"integer";case"BOOLEAN":return"boolean";case"DATE":case"TIMESTAMP":case"TIMESTAMP WITH TIME ZONE":return"date";case"VARCHAR":case"UUID":return"string";default:return/^DECIMAL\(/.test(e)?"integer":"other"}}function zt(e,t){return function(n){var r,a,o,i,s,c,l,u,f=n[0],d=[],p=null,h=-1;for(s=1,c=arguments.length;s<c;++s){if((r=arguments[s])instanceof Node)d[++h]=r,f+="\x3c!--o:"+h+"--\x3e";else if(Array.isArray(r)){for(l=0,u=r.length;l<u;++l)(a=r[l])instanceof Node?(null===p&&(d[++h]=p=document.createDocumentFragment(),f+="\x3c!--o:"+h+"--\x3e"),p.appendChild(a)):(p=null,f+=a);p=null}else f+=r;f+=n[s]}if(p=e(f),++h>0){for(o=new Array(h),i=document.createTreeWalker(p,NodeFilter.SHOW_COMMENT,null,!1);i.nextNode();)a=i.currentNode,/^o:/.test(a.nodeValue)&&(o[+a.nodeValue.slice(2)]=a);for(s=0;s<h;++s)(a=o[s])&&a.parentNode.replaceChild(d[s],a)}return 1===p.childNodes.length?p.removeChild(p.firstChild):11===p.nodeType?((a=t()).appendChild(p),a):p}}Object.defineProperty(DuckDBClient.prototype,"dialect",{value:"duckdb"});const Wt=zt((function(e){var t=document.createElement("template");return t.innerHTML=e.trim(),document.importNode(t.content,!0)}),(function(){return document.createElement("span")}));function Ht(e){let t;Object.defineProperties(this,{generator:{value:St((e=>{t=e}))},value:{get:()=>e,set:n=>t(e=n)}}),void 0!==e&&t(e)}function*Vt(){for(;;)yield Date.now()}var Gt=new Map;function Yt(e,t){var n;return(n=Gt.get(e=+e))?n.then((()=>t)):(n=Date.now())>=e?Promise.resolve(t):function(e,t){var n=new Promise((function(n){Gt.delete(t);var r=t-e;if(!(r>0))throw new Error("invalid time");if(r>2147483647)throw new Error("too long to wait");setTimeout(n,r)}));return Gt.set(t,n),n}(n,e).then((()=>t))}var Zt=Object.freeze({__proto__:null,delay:function(e,t){return new Promise((function(n){setTimeout((function(){n(t)}),e)}))},tick:function(e,t){return Yt(Math.ceil((Date.now()+1)/e)*e,t)},when:Yt});function Jt(e,t){if(/^(\w+:)|\/\//i.test(e))return e;if(/^[.]{0,2}\//i.test(e))return new URL(e,null==t?location:t).href;if(!e.length||/^[\s._]/.test(e)||/\s$/.test(e))throw new Error("illegal name");return"https://unpkg.com/"+e}const Kt=zt((function(e){var t=document.createElementNS("http://www.w3.org/2000/svg","g");return t.innerHTML=e.trim(),t}),(function(){return document.createElementNS("http://www.w3.org/2000/svg","g")}));var Xt=String.raw;function Qt(e){return new Promise((function(t,n){var r=document.createElement("link");r.rel="stylesheet",r.href=e,r.onerror=n,r.onload=t,document.head.appendChild(r)}))}function en(){return St((function(e){var t=e(document.body.clientWidth);function n(){var n=document.body.clientWidth;n!==t&&e(t=n)}return window.addEventListener("resize",n),function(){window.removeEventListener("resize",n)}}))}function tn(e){return Array.isArray(e)&&(n=e.schema,Array.isArray(n)&&n.every((e=>e&&"string"==typeof e.name))||(t=e.columns,Array.isArray(t)&&t.every((e=>"string"==typeof e)))||function(e){const t=Math.min(20,e.length);for(let n=0;n<t;++n){const t=e[n];if(null===t||"object"!=typeof t)return!1}return t>0&&function(e){for(const t in e)return!0;return!1}(e[0])}(e)||rn(e)||an(e))||on(e);var t,n}function nn(e){return on(e)||rn(e)||an(e)}function rn(e){const t=Math.min(20,e.length);if(!(t>0))return!1;let n,r=!1;for(let a=0;a<t;++a){const t=e[a];if(null==t)continue;const o=typeof t;if(void 0===n)switch(o){case"number":case"boolean":case"string":case"bigint":n=o;break;default:return!1}else if(o!==n)return!1;r=!0}return r}function an(e){const t=Math.min(20,e.length);if(!(t>0))return!1;let n=!1;for(let r=0;r<t;++r){const t=e[r];if(null!=t){if(!(t instanceof Date))return!1;n=!0}}return n}function on(e){return e instanceof Int8Array||e instanceof Int16Array||e instanceof Int32Array||e instanceof Uint8Array||e instanceof Uint8ClampedArray||e instanceof Uint16Array||e instanceof Uint32Array||e instanceof Float32Array||e instanceof Float64Array}const sn=Object.assign((async(e,t,n,r)=>{if(e=await ln(await e,r),(a=e)&&("function"==typeof a.sql||"function"==typeof a.queryTag&&("function"==typeof a.query||"function"==typeof a.queryStream))&&("table"!==o||"function"==typeof a.describeColumns)&&a!==sn)return dn(e,function(e,t){const n="function"==typeof t.escape?t.escape:e=>e,{select:r,from:a,filter:o,sort:i,slice:s}=e;if(!a.table)throw new Error("missing from table");if(r.columns&&0===r.columns.length)throw new Error("at least one column must be selected");const c=[[`SELECT ${r.columns?r.columns.map(n).join(", "):"*"} FROM ${pn(a.table,n)}`]];for(let e=0;e<o.length;++e)hn(e?"\nAND ":"\nWHERE ",c),bn(o[e],c,n);for(let e=0;e<i.length;++e)hn(e?", ":"\nORDER BY ",c),mn(i[e],c,n);if("mssql"===t.dialect||"oracle"===t.dialect){if(null!==s.to||null!==s.from){if(!i.length){if(!r.columns)throw new Error("at least one column must be explicitly specified. Received '*'.");hn("\nORDER BY ",c),mn({column:r.columns[0],direction:"ASC"},c,n)}hn(`\nOFFSET ${s.from||0} ROWS`,c),hn(`\nFETCH NEXT ${null!==s.to?s.to-(s.from||0):1e9} ROWS ONLY`,c)}}else null===s.to&&null===s.from||hn("\nLIMIT "+(null!==s.to?s.to-(s.from||0):1e9),c),null!==s.from&&hn(` OFFSET ${s.from}`,c);return c}(t,e),n);var a,o;if(tn(e))return function(e,t){const n=e;let{schema:r,columns:a}=e,o=nn(e);o&&(e=Array.from(e,(e=>({value:e}))));for(const{type:n,operands:r}of t.filter){const[{value:t}]=r,a=r.slice(1).map((({value:e})=>e));switch(n){case"v":{const[n]=a,r=qn(n);e=e.filter((e=>r(e[t])));break}case"nv":{const[n]=a,r=qn(n);e=e.filter((e=>!r(e[t])));break}case"eq":{const[n]=a;if(n instanceof Date){const r=+n;e=e.filter((e=>+e[t]===r))}else e=e.filter((e=>e[t]===n));break}case"ne":{const[n]=a;e=e.filter((e=>e[t]!==n));break}case"c":{const[n]=a;e=e.filter((e=>"string"==typeof e[t]&&e[t].includes(n)));break}case"nc":{const[n]=a;e=e.filter((e=>"string"==typeof e[t]&&!e[t].includes(n)));break}case"in":{const n=new Set(a);e=e.filter((e=>n.has(e[t])));break}case"nin":{const n=new Set(a);e=e.filter((e=>!n.has(e[t])));break}case"n":e=e.filter((e=>null==e[t]));break;case"nn":e=e.filter((e=>null!=e[t]));break;case"lt":{const[n]=a;e=e.filter((e=>e[t]<n));break}case"lte":{const[n]=a;e=e.filter((e=>e[t]<=n));break}case"gt":{const[n]=a;e=e.filter((e=>e[t]>n));break}case"gte":{const[n]=a;e=e.filter((e=>e[t]>=n));break}default:throw new Error(`unknown filter type: ${n}`)}}for(const{column:r,direction:a}of function(e){if("function"!=typeof e[Symbol.iterator])throw new TypeError("values is not iterable");return Array.from(e).reverse()}(t.sort)){const t="desc"===a?_n:yn;e===n&&(e=e.slice()),e.sort(((e,n)=>t(e[r],n[r])))}let{from:i,to:s}=t.slice;i=null==i?0:Math.max(0,i),s=null==s?1/0:Math.max(0,s),(i>0||s<1/0)&&(e=e.slice(Math.max(0,i),Math.max(0,s)));if(t.select.columns){if(r){const e=new Map(r.map((e=>[e.name,e])));r=t.select.columns.map((t=>e.get(t)))}a&&(a=t.select.columns),e=e.map((e=>Object.fromEntries(t.select.columns.map((t=>[t,e[t]])))))}o&&(e=e.map((e=>e.value)));e!==n&&(r&&(e.schema=r),a&&(e.columns=a));return e}(e,t);if(!e)throw new Error("missing data source");throw new Error("invalid data source")}),{sql:(e,t,n)=>async function(){return dn(await un(await e,n),arguments,t)}});function cn(e){const t=new WeakMap;return(n,r)=>{if(!n)throw new Error("data source not found");let a=t.get(n);return(!a||tn(n)&&n.length!==a._numRows)&&(a=e(n,r),a._numRows=n.length,t.set(n,a)),a}}const ln=cn((async(e,t)=>{if(e instanceof FileAttachment){switch(e.mimeType){case"text/csv":return e.csv({typed:!0});case"text/tab-separated-values":return e.tsv({typed:!0});case"application/json":return e.json();case"application/x-sqlite3":return e.sqlite()}if(/\.(arrow|parquet)$/i.test(e.name))return fn(e,t);throw new Error(`unsupported file type: ${e.mimeType}`)}return Mt(e)||kt(e)?fn(e,t):e})),un=cn((async(e,t)=>{if(e instanceof FileAttachment){switch(e.mimeType){case"text/csv":case"text/tab-separated-values":case"application/json":return fn(e,t);case"application/x-sqlite3":return e.sqlite()}if(/\.(arrow|parquet)$/i.test(e.name))return fn(e,t);throw new Error(`unsupported file type: ${e.mimeType}`)}return tn(e)?fn(await async function(e,t){const n=await Pt();return nn(e)?n.tableFromArrays({[t]:e}):n.tableFromJSON(e)}(e,t),t):Mt(e)||kt(e)?fn(e,t):e}));function fn(e,t=(e instanceof FileAttachment?function(e){return e.name.replace(/@\d+(?=\.|$)/,"").replace(/\.\w+$/,"")}(e):"__table")){return DuckDBClient.of({[t]:e})}async function dn(e,t,n){if(!e)throw new Error("missing data source");if("function"==typeof e.queryTag){const r=new AbortController,a={signal:r.signal};if(n.then((()=>r.abort("invalidated"))),"function"==typeof e.queryStream)return async function*(e){let t=performance.now();const n=await e,r=[];r.done=!1,r.error=null,r.schema=n.schema;try{for await(const e of n.readRows()){performance.now()-t>10&&r.length>0&&(yield r,t=performance.now());for(const t of e)r.push(t)}r.done=!0,yield r}catch(e){r.error=e,yield r}}(e.queryStream(...e.queryTag.apply(e,t),a));if("function"==typeof e.query)return e.query(...e.queryTag.apply(e,t),a)}if("function"==typeof e.sql)return e.sql.apply(e,t);throw new Error("source does not implement query, queryStream, or sql")}function pn(e,t){if("object"==typeof e){let n="";return null!=e.database&&(n+=t(e.database)+"."),null!=e.schema&&(n+=t(e.schema)+"."),n+=t(e.table),n}return t(e)}function hn(e,t){const n=t[0];n[n.length-1]+=e}function mn({column:e,direction:t},n,r){hn(`${r(e)} ${t.toUpperCase()}`,n)}function bn({type:e,operands:t},n,r){if(t.length<1)throw new Error("Invalid operand length");if(1===t.length||"v"===e||"nv"===e)switch(vn(t[0],n,r),e){case"n":case"nv":return void hn(" IS NULL",n);case"nn":case"v":return void hn(" IS NOT NULL",n);default:throw new Error("Invalid filter operation")}if(2!==t.length||["in","nin"].includes(e)){var a;switch(vn(t[0],n,r),e){case"in":hn(" IN (",n);break;case"nin":hn(" NOT IN (",n);break;default:throw new Error("Invalid filter operation")}!function(e,t){let n=!0;for(const r of e)n?n=!1:hn(",",t),t.push(r.value),t[0].push("")}(t.slice(1),n),hn(")",n)}else{if(["c","nc"].includes(e)){switch(vn(t[0],n,r),e){case"c":hn(" LIKE ",n);break;case"nc":hn(" NOT LIKE ",n)}return void vn((a=t[1],{...a,value:`%${a.value}%`}),n,r)}switch(vn(t[0],n,r),e){case"eq":hn(" = ",n);break;case"ne":hn(" <> ",n);break;case"gt":hn(" > ",n);break;case"lt":hn(" < ",n);break;case"gte":hn(" >= ",n);break;case"lte":hn(" <= ",n);break;default:throw new Error("Invalid filter operation")}vn(t[1],n,r)}}function vn(e,t,n){"column"===e.type?hn(n(e.value),t):(t.push(e.value),t[0].push(""))}function wn(e,t){return(null==e||!(e>=e))-(null==t||!(t>=t))}function yn(e,t){return wn(e,t)||(e<t?-1:e>t?1:0)}function _n(e,t){return wn(e,t)||(e>t?-1:e<t?1:0)}const gn=e=>"number"==typeof e&&!Number.isNaN(e),En=e=>"string"==typeof e,Cn=e=>"boolean"==typeof e,xn=e=>"bigint"==typeof e,Nn=e=>e instanceof Date&&!isNaN(e),Tn=e=>e instanceof ArrayBuffer,An=e=>Array.isArray(e),jn=e=>"object"==typeof e&&null!==e,$n=e=>null!=e;function qn(e){switch(e){case"string":return En;case"bigint":return xn;case"boolean":return Cn;case"number":return gn;case"date":return Nn;case"buffer":return Tn;case"array":return An;case"object":return jn;default:return $n}}const Library=Object.assign(Object.defineProperties((function(e){const t=function(e){return null==e?lt:rt(e)}(e);var n;Object.defineProperties(this,(n={FileAttachment:()=>Et,Mutable:()=>Ht,now:Vt,width:en,dot:()=>t(Ae.resolve()),htl:()=>t(Se.resolve()),html:()=>Wt,md:()=>function(e){return e(Le.resolve()).then((function(t){return zt((function(n){var r=document.createElement("div");r.innerHTML=t(n,{langPrefix:""}).trim();var a=r.querySelectorAll("pre code[class]");return a.length>0&&e(je.resolve()).then((function(t){a.forEach((function(n){function r(){t.highlightBlock(n),n.parentNode.classList.add("observablehq--md-pre")}t.getLanguage(n.className)?r():e(je.resolve("async-languages/index.js")).then((r=>{if(r.has(n.className))return e(je.resolve("async-languages/"+r.get(n.className))).then((e=>{t.registerLanguage(n.className,e)}))})).then(r,r)}))})),r}),(function(){return document.createElement("div")}))}))}(t),svg:()=>Kt,tex:()=>function(e){return Promise.all([e($e.resolve()),e.resolve($e.resolve("dist/katex.min.css")).then(Qt)]).then((function(e){var t=e[0],n=r();function r(e){return function(){var n=document.createElement("div");return t.render(Xt.apply(String,arguments),n,e),n.removeChild(n.firstChild)}}return n.options=r,n.block=r({displayMode:!0}),n}))}(t),_:()=>t(qe.resolve()),aq:()=>t.alias({"apache-arrow":Pe.resolve()})(De.resolve()),Arrow:()=>t(Pe.resolve()),d3:()=>t(xe.resolve()),DuckDBClient:()=>DuckDBClient,Inputs:()=>t(Ne.resolve()).then((e=>({...e,file:e.fileOf(gt)}))),L:()=>async function(e){const t=await e(We.resolve());if(!t._style){const n=document.createElement("link");n.rel="stylesheet",n.href=await e.resolve(We.resolve("dist/leaflet.css")),t._style=document.head.appendChild(n)}return t}(t),mermaid:()=>async function(e){const t=await e(ze.resolve());return t.initialize({securityLevel:"loose",theme:"neutral"}),function(){const e=document.createElement("div");return e.innerHTML=t.render(Nt().id,String.raw.apply(String,arguments)),e.removeChild(e.firstChild)}}(t),Plot:()=>t(Te.resolve()),__query:()=>sn,require:()=>t,resolve:()=>Jt,SQLite:()=>ut(t),SQLiteDatabaseClient:()=>SQLiteDatabaseClient,topojson:()=>t(Fe.resolve()),vl:()=>async function(e){const[t,n,r]=await Promise.all([Me,Re,Ie].map((t=>e(t.resolve()))));return r.register(t,n)}(t),aapl:()=>new FileAttachment("https://static.observableusercontent.com/files/3ccff97fd2d93da734e76829b2b066eafdaac6a1fafdec0faf6ebc443271cfc109d29e80dd217468fcb2aff1e6bffdc73f356cc48feb657f35378e6abbbb63b9").csv({typed:!0}),alphabet:()=>new FileAttachment("https://static.observableusercontent.com/files/75d52e6c3130b1cae83cda89305e17b50f33e7420ef205587a135e8562bcfd22e483cf4fa2fb5df6dff66f9c5d19740be1cfaf47406286e2eb6574b49ffc685d").csv({typed:!0}),cars:()=>new FileAttachment("https://static.observableusercontent.com/files/048ec3dfd528110c0665dfa363dd28bc516ffb7247231f3ab25005036717f5c4c232a5efc7bb74bc03037155cb72b1abe85a33d86eb9f1a336196030443be4f6").csv({typed:!0}),citywages:()=>new FileAttachment("https://static.observableusercontent.com/files/39837ec5121fcc163131dbc2fe8c1a2e0b3423a5d1e96b5ce371e2ac2e20a290d78b71a4fb08b9fa6a0107776e17fb78af313b8ea70f4cc6648fad68ddf06f7a").csv({typed:!0}),diamonds:()=>new FileAttachment("https://static.observableusercontent.com/files/87942b1f5d061a21fa4bb8f2162db44e3ef0f7391301f867ab5ba718b225a63091af20675f0bfe7f922db097b217b377135203a7eab34651e21a8d09f4e37252").csv({typed:!0}),flare:()=>new FileAttachment("https://static.observableusercontent.com/files/a6b0d94a7f5828fd133765a934f4c9746d2010e2f342d335923991f31b14120de96b5cb4f160d509d8dc627f0107d7f5b5070d2516f01e4c862b5b4867533000").csv({typed:!0}),industries:()=>new FileAttachment("https://static.observableusercontent.com/files/76f13741128340cc88798c0a0b7fa5a2df8370f57554000774ab8ee9ae785ffa2903010cad670d4939af3e9c17e5e18e7e05ed2b38b848ac2fc1a0066aa0005f").csv({typed:!0}),miserables:()=>new FileAttachment("https://static.observableusercontent.com/files/31d904f6e21d42d4963ece9c8cc4fbd75efcbdc404bf511bc79906f0a1be68b5a01e935f65123670ed04e35ca8cae3c2b943f82bf8db49c5a67c85cbb58db052").json(),olympians:()=>new FileAttachment("https://static.observableusercontent.com/files/31ca24545a0603dce099d10ee89ee5ae72d29fa55e8fc7c9ffb5ded87ac83060d80f1d9e21f4ae8eb04c1e8940b7287d179fe8060d887fb1f055f430e210007c").csv({typed:!0}),penguins:()=>new FileAttachment("https://static.observableusercontent.com/files/715db1223e067f00500780077febc6cebbdd90c151d3d78317c802732252052ab0e367039872ab9c77d6ef99e5f55a0724b35ddc898a1c99cb14c31a379af80a").csv({typed:!0}),weather:()=>new FileAttachment("https://static.observableusercontent.com/files/693a46b22b33db0f042728700e0c73e836fa13d55446df89120682d55339c6db7cc9e574d3d73f24ecc9bc7eb9ac9a1e7e104a1ee52c00aab1e77eb102913c1f").csv({typed:!0}),DOM:At,Files:jt,Generators:Lt,Promises:Zt},Object.fromEntries(Object.entries(n).map(Sn))))}),{resolve:{get:()=>lt.resolve,enumerable:!0,configurable:!0},require:{get:()=>lt,set:function(e){lt=e},enumerable:!0,configurable:!0}}),{resolveFrom:tt,requireFrom:rt});function Sn([e,t]){return[e,{value:t,writable:!0,enumerable:!0}]}class RuntimeError extends Error{constructor(e,t){super(e),this.input=t}}function On(e){return()=>e}function Ln(e){return e}RuntimeError.prototype.name="RuntimeError";const kn=Array.prototype.map;function Mn(){}const Rn=Symbol("no-observer");function Variable(e,t,n){var r;n||(n=Rn),Object.defineProperties(this,{_observer:{value:n,writable:!0},_definition:{value:Un,writable:!0},_duplicate:{value:void 0,writable:!0},_duplicates:{value:void 0,writable:!0},_indegree:{value:NaN,writable:!0},_inputs:{value:[],writable:!0},_invalidate:{value:Mn,writable:!0},_module:{value:t},_name:{value:null,writable:!0},_outputs:{value:new Set,writable:!0},_promise:{value:Promise.resolve(void 0),writable:!0},_reachable:{value:n!==Rn,writable:!0},_rejector:{value:(r=this,e=>{if(e===Dn)throw e;if(e===Un)throw new RuntimeError(`${r._name} is not defined`,r._name);if(e instanceof Error&&e.message)throw new RuntimeError(e.message,r._name);throw new RuntimeError(`${r._name} could not be resolved`,r._name)})},_type:{value:e},_value:{value:void 0,writable:!0},_version:{value:0,writable:!0}})}function In(e){e._module._runtime._dirty.add(e),e._outputs.add(this)}function Pn(e){e._module._runtime._dirty.add(e),e._outputs.delete(this)}function Un(){throw Un}function Dn(){throw Dn}function Fn(e){return()=>{throw new RuntimeError(`${e} is defined more than once`)}}function Bn(e,t,n){const r=this._module._scope,a=this._module._runtime;if(this._inputs.forEach(Pn,this),t.forEach(In,this),this._inputs=t,this._definition=n,this._value=void 0,n===Mn?a._variables.delete(this):a._variables.add(this),e!==this._name||r.get(e)!==this){let t,o;if(this._name)if(this._outputs.size)r.delete(this._name),o=this._module._resolve(this._name),o._outputs=this._outputs,this._outputs=new Set,o._outputs.forEach((function(e){e._inputs[e._inputs.indexOf(this)]=o}),this),o._outputs.forEach(a._updates.add,a._updates),a._dirty.add(o).add(this),r.set(this._name,o);else if((o=r.get(this._name))===this)r.delete(this._name);else{if(3!==o._type)throw new Error;o._duplicates.delete(this),this._duplicate=void 0,1===o._duplicates.size&&(o=o._duplicates.keys().next().value,t=r.get(this._name),o._outputs=t._outputs,t._outputs=new Set,o._outputs.forEach((function(e){e._inputs[e._inputs.indexOf(t)]=o})),o._definition=o._duplicate,o._duplicate=void 0,a._dirty.add(t).add(o),a._updates.add(o),r.set(this._name,o))}if(this._outputs.size)throw new Error;e&&((o=r.get(e))?3===o._type?(this._definition=Fn(e),this._duplicate=n,o._duplicates.add(this)):2===o._type?(this._outputs=o._outputs,o._outputs=new Set,this._outputs.forEach((function(e){e._inputs[e._inputs.indexOf(o)]=this}),this),a._dirty.add(o).add(this),r.set(e,this)):(o._duplicate=o._definition,this._duplicate=n,t=new Variable(3,this._module),t._name=e,t._definition=this._definition=o._definition=Fn(e),t._outputs=o._outputs,o._outputs=new Set,t._outputs.forEach((function(e){e._inputs[e._inputs.indexOf(o)]=t})),t._duplicates=new Set([this,o]),a._dirty.add(o).add(t),a._updates.add(o).add(t),r.set(e,t)):r.set(e,this)),this._name=e}return this._version>0&&++this._version,a._updates.add(this),a._compute(),this}Object.defineProperties(Variable.prototype,{_pending:{value:function(){this._observer.pending&&this._observer.pending()},writable:!0,configurable:!0},_fulfilled:{value:function(e){this._observer.fulfilled&&this._observer.fulfilled(e,this._name)},writable:!0,configurable:!0},_rejected:{value:function(e){this._observer.rejected&&this._observer.rejected(e,this._name)},writable:!0,configurable:!0},define:{value:function(e,t,n){switch(arguments.length){case 1:n=e,e=t=null;break;case 2:n=t,"string"==typeof e?t=null:(t=e,e=null)}return Bn.call(this,null==e?null:String(e),null==t?[]:kn.call(t,this._module._resolve,this._module),"function"==typeof n?n:On(n))},writable:!0,configurable:!0},delete:{value:function(){return Bn.call(this,null,[],Mn)},writable:!0,configurable:!0},import:{value:function(e,t,n){arguments.length<3&&(n=t,t=e);return Bn.call(this,String(t),[n._resolve(String(e))],Ln)},writable:!0,configurable:!0}});const zn=Symbol("variable"),Wn=Symbol("invalidation"),Hn=Symbol("visibility");function Module(e,t=[]){Object.defineProperties(this,{_runtime:{value:e},_scope:{value:new Map},_builtins:{value:new Map([["@variable",zn],["invalidation",Wn],["visibility",Hn],...t])},_source:{value:null,writable:!0}})}async function Vn(e,t){await e._compute();try{return await t._promise}catch(n){if(n===Dn)return Vn(e,t);throw n}}function Gn(e){return e._name}Object.defineProperties(Module.prototype,{_resolve:{value:function(e){let t,n=this._scope.get(e);if(!n)if(n=new Variable(2,this),this._builtins.has(e))n.define(e,On(this._builtins.get(e)));else if(this._runtime._builtin._scope.has(e))n.import(e,this._runtime._builtin);else{try{t=this._runtime._global(e)}catch(t){return n.define(e,function(e){return()=>{throw e}}(t))}void 0===t?this._scope.set(n._name=e,n):n.define(e,On(t))}return n},writable:!0,configurable:!0},redefine:{value:function(e){const t=this._scope.get(e);if(!t)throw new RuntimeError(`${e} is not defined`);if(3===t._type)throw new RuntimeError(`${e} is defined more than once`);return t.define.apply(t,arguments)},writable:!0,configurable:!0},define:{value:function(){const e=new Variable(1,this);return e.define.apply(e,arguments)},writable:!0,configurable:!0},derive:{value:function(e,t){const n=new Map,r=new Set,a=[];function o(e){let t=n.get(e);return t||(t=new Module(e._runtime,e._builtins),t._source=e,n.set(e,t),a.push([t,e]),r.add(e),t)}const i=o(this);for(const n of e){const{alias:e,name:r}="object"==typeof n?n:{name:n};i.import(r,null==e?r:e,t)}for(const e of r)for(const[t,n]of e._scope)if(n._definition===Ln){if(e===this&&i._scope.has(t))continue;const r=n._inputs[0]._module;r._source&&o(r)}for(const[e,t]of a)for(const[r,a]of t._scope){const t=e._scope.get(r);if(!t||2===t._type)if(a._definition===Ln){const t=a._inputs[0],o=t._module;e.import(t._name,r,n.get(o)||o)}else e.define(r,a._inputs.map(Gn),a._definition)}return i},writable:!0,configurable:!0},import:{value:function(){const e=new Variable(1,this);return e.import.apply(e,arguments)},writable:!0,configurable:!0},value:{value:async function(e){let t=this._scope.get(e);if(!t)throw new RuntimeError(`${e} is not defined`);if(t._observer!==Rn)return Vn(this._runtime,t);t=this.variable(!0).define([e],Ln);try{return await Vn(this._runtime,t)}finally{t.delete()}},writable:!0,configurable:!0},variable:{value:function(e){return new Variable(1,this,e)},writable:!0,configurable:!0},builtin:{value:function(e,t){this._builtins.set(e,t)},writable:!0,configurable:!0}});const Yn="function"==typeof requestAnimationFrame?requestAnimationFrame:"function"==typeof setImmediate?setImmediate:e=>setTimeout(e,0);function Runtime(e=new Library,t=rr){const n=this.module();if(Object.defineProperties(this,{_dirty:{value:new Set},_updates:{value:new Set},_precomputes:{value:[],writable:!0},_computing:{value:null,writable:!0},_init:{value:null,writable:!0},_modules:{value:new Map},_variables:{value:new Set},_disposed:{value:!1,writable:!0},_builtin:{value:n},_global:{value:t}}),e)for(const t in e)new Variable(2,n).define(t,[],e[t])}function Zn(e){const t=new Set(e._inputs);for(const n of t){if(n===e)return!0;n._inputs.forEach(t.add,t)}return!1}function Jn(e){++e._indegree}function Kn(e){--e._indegree}function Xn(e){return e._promise.catch(e._rejector)}function Qn(e){return new Promise((function(t){e._invalidate=t}))}function er(e,t){let n,r,a="function"==typeof IntersectionObserver&&t._observer&&t._observer._node,o=!a,i=Mn,s=Mn;return a&&(r=new IntersectionObserver((([e])=>(o=e.isIntersecting)&&(n=null,i()))),r.observe(a),e.then((()=>(r.disconnect(),r=null,s())))),function(e){return o?Promise.resolve(e):r?(n||(n=new Promise(((e,t)=>(i=e,s=t)))),n.then((()=>e))):Promise.reject()}}function tr(e){e._invalidate(),e._invalidate=Mn,e._pending();const t=e._value,n=++e._version;let r=null;const a=e._promise=(e._inputs.length?Promise.all(e._inputs.map(Xn)).then((function(a){if(e._version!==n)throw Dn;for(let t=0,n=a.length;t<n;++t)switch(a[t]){case Wn:a[t]=r=Qn(e);break;case Hn:r||(r=Qn(e)),a[t]=er(r,e);break;case zn:a[t]=e}return e._definition.apply(t,a)})):new Promise((n=>n(e._definition.call(t))))).then((function(t){if(e._version!==n)throw Dn;if(function(e){return e&&"function"==typeof e.next&&"function"==typeof e.return}(t))return(r||Qn(e)).then((a=t,function(){a.return()})),function(e,t,n){const r=e._module._runtime;let a;function o(e){return new Promise((e=>e(n.next(a)))).then((({done:t,value:n})=>t?void 0:Promise.resolve(n).then(e)))}function i(){const n=o((o=>{if(e._version!==t)throw Dn;return a=o,s(o,n).then((()=>r._precompute(i))),e._fulfilled(o),o}));n.catch((r=>{r!==Dn&&e._version===t&&(s(void 0,n),e._rejected(r))}))}function s(t,n){return e._value=t,e._promise=n,e._outputs.forEach(r._updates.add,r._updates),r._compute()}return o((n=>{if(e._version!==t)throw Dn;return a=n,r._precompute(i),n}))}(e,n,t);var a;return t}));a.then((t=>{e._value=t,e._fulfilled(t)}),(t=>{t!==Dn&&(e._value=void 0,e._rejected(t))}))}function nr(e,t){e._invalidate(),e._invalidate=Mn,e._pending(),++e._version,e._indegree=NaN,(e._promise=Promise.reject(t)).catch(Mn),e._value=void 0,e._rejected(t)}function rr(e){return globalThis[e]}Object.defineProperties(Runtime.prototype,{_precompute:{value:function(e){this._precomputes.push(e),this._compute()},writable:!0,configurable:!0},_compute:{value:function(){return this._computing||(this._computing=this._computeSoon())},writable:!0,configurable:!0},_computeSoon:{value:function(){return new Promise(Yn).then((()=>this._disposed?void 0:this._computeNow()))},writable:!0,configurable:!0},_computeNow:{value:async function(){let e,t,n=[],r=this._precomputes;if(r.length){this._precomputes=[];for(const e of r)e();await function(e=0){let t=Promise.resolve();for(let n=0;n<e;++n)t=t.then((()=>{}));return t}(3)}e=new Set(this._dirty),e.forEach((function(t){t._inputs.forEach(e.add,e);const n=function(e){if(e._observer!==Rn)return!0;const t=new Set(e._outputs);for(const e of t){if(e._observer!==Rn)return!0;e._outputs.forEach(t.add,t)}return!1}(t);n>t._reachable?this._updates.add(t):n<t._reachable&&t._invalidate(),t._reachable=n}),this),e=new Set(this._updates),e.forEach((function(t){t._reachable?(t._indegree=0,t._outputs.forEach(e.add,e)):(t._indegree=NaN,e.delete(t))})),this._computing=null,this._updates.clear(),this._dirty.clear(),e.forEach((function(e){e._outputs.forEach(Jn)}));do{for(e.forEach((function(e){0===e._indegree&&n.push(e)}));t=n.pop();)tr(t),t._outputs.forEach(a),e.delete(t);e.forEach((function(t){Zn(t)&&(nr(t,new RuntimeError("circular definition")),t._outputs.forEach(Kn),e.delete(t))}))}while(e.size);function a(e){0==--e._indegree&&n.push(e)}},writable:!0,configurable:!0},dispose:{value:function(){this._computing=Promise.resolve(),this._disposed=!0,this._variables.forEach((e=>{e._invalidate(),e._version=NaN}))},writable:!0,configurable:!0},module:{value:function(e,t=Mn){let n;if(void 0===e)return(n=this._init)?(this._init=null,n):new Module(this);if(n=this._modules.get(e),n)return n;this._init=n=new Module(this),this._modules.set(e,n);try{e(this,t)}finally{this._init=null}return n},writable:!0,configurable:!0},fileAttachments:{value:function(e){return Object.assign((t=>{const n=e(t+="");if(null==n)throw new Error(`File not found: ${t}`);if("object"==typeof n&&"url"in n){const{url:e,mimeType:r}=n;return new FileAttachment(e,t,r)}return new FileAttachment(n,t)}),{prototype:FileAttachment.prototype})},writable:!0,configurable:!0}});export{Inspector,Library,Runtime,RuntimeError};


    const runtime = new Runtime();
    // const main = runtime.module(define, Inspector.into(document.body));
    const main = runtime.module(define, Inspector.into(document.body));
</script>

<script>
    $(document).ready(function() {

        function initReport() {
            var urlVal = new URL(window.location);
            var param = urlVal.searchParams.get("id");

            document.getElementById("id").value = param;
            document.getElementById('chartForm').submit();


            console.log(document.getElementById("catChart").value);
            console.log(document.getElementById("radarChart").value);
        }

        setTimeout(initReport, 5000);
    });
</script>

@endsection

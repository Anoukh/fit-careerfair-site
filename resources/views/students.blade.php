@extends('layouts.master')

@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.css">
    <style>
        .list-group-item em{
            font-style: normal;
            color: #ffbe18;
        }
        .ais-infinite-hits--showmore button{
            border-radius: 5px;
            border: solid 1px #8c8a8a;
            box-shadow: none;
            background-color: #ffbe62;
        }
    </style>
@endsection

@section('content')

    <div class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><i class="fa fa-graduation-cap"></i></h4>
                </div>
                <div class="modal-body">
                    <img src="/img/ajaxloading.gif" class="loading-img" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<div class="container" style="padding-top: 72px">
    <div class="panel panel-default">
        <div id="student" class="panel-body">
            {{--<div style="text-align: right; padding-right: 20px">{{ $students->links() }}</div>--}}
            <div id="student-list" class="list-group">
                {{--@foreach($students as $student)--}}
                    {{--<div class="item">--}}
                        {{--<div class="list-group-item">--}}
                            {{--<div class="row-picture">--}}
                                {{--<img class="circle" src="{{$student->img}}" alt="icon">--}}
                            {{--</div>--}}
                            {{--<div class="row-content">--}}
                                {{--<h4 style="font-weight: 500;" class="list-group-item-heading">{{$student->firstName}} {{$student->lastName}}</h4>--}}

                                {{--<p class="list-group-item-text text-justify">{{$student->objective}}</p>--}}
                                {{--@foreach(explode(",", $student->techs) as $tech)--}}
                                    {{--<span style="margin-bottom: 10px" class="label label-default">{{$tech}}</span>--}}
                                {{--@endforeach--}}
                                {{--<a style="color: #00b0ff; float: right" onclick="viewProfile('{{$student->index}}');" class="btn btn-raised btn-xs">read more</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="list-group-separator"></div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            </div>

            {{--<div style="padding-left: 20px">{{ $students->links() }}</div>--}}
        </div>
    </div>

</div>
    <script>

    </script>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js"></script>

{{--<script src="/js/jquery.jscroll.min.js"></script>--}}
    <script>


        var search = instantsearch({
            appId: 'SJVT4MYY9W',
            apiKey: '00c555e851bafeb934e53535d7c4f6fd',
            indexName: 'profiles',
            urlSync: {}
        });

        search.addWidget(
                instantsearch.widgets.searchBox({
                    container: '#q',
                    placeholder: 'Search for students...'
                })
        );


        var hitTemplate =
                '<div class="item">' +
                    '<div class="list-group-item">' +
                        '<div class="row-picture">' +
                            '<img class="circle" src="img/student.jpg" alt="icon">' +
                        '</div>' +
                        '<div class="row-content">' +
                            '<h4 style="font-weight: 500;" class="list-group-item-heading">\{\{\{_highlightResult.firstName.value\}\}\} \{\{\{_highlightResult.lastName.value\}\}\}</h4>' +
                            '<p class="list-group-item-text text-justify">\{\{\{_highlightResult.objective.value\}\}\}</p>' +
                            '<span style="margin-bottom: 10px" class="label label-default">' + '\{\{\{_highlightResult.techs.value\}\}\}</span>' +
                            '<a style="color: #00b0ff; float: right" onclick="viewProfile(\'\{\{index\}\}\');" class="btn btn-raised btn-xs">read more</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="list-group-separator"></div>' +
                '</div>';


        search.addWidget(
                instantsearch.widgets.infiniteHits({
                    container: '#student-list',
                    hitsPerPage: 10,
                    cssClasses: 'btn btn-default',
                    templates: {
                        item: function(data) {
                            var techArray = data._highlightResult.techs.value.split(',');
                            var techhtml = '';


                            techArray.forEach(function(tech) {
                                techhtml = techhtml.concat('<span style="margin-bottom: 10px" class="label label-default">' + tech +'</span>');
                            });

                            return '<div class="item">' +
                                    '<div class="list-group-item">' +
                                    '<div class="row-picture">' +
                                    '<img class="circle" src="img/student.jpg" alt="icon">' +
                                    '</div>' +
                                    '<div class="row-content">' +
                                    '<h4 style="font-weight: 500;" class="list-group-item-heading">'+ data._highlightResult.firstName.value + ' ' +data._highlightResult.lastName.value + '</h4>' +
                                    '<p class="list-group-item-text text-justify">'+data._highlightResult.objective.value+'</p>' +
                                    techhtml +
                                    '<a style="color: #00b0ff; float: right" onclick="viewProfile(\''+ data.index +'\');" class="btn btn-raised btn-xs">read more</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="list-group-separator"></div>' +
                                    '</div>';
                        }
                    }
                })
        );

        search.start();

        search.templatesConfig.helpers.techs = function(/*text, render*/) {
            var discount = this.price * 0.3;
            return '$ -' + discount;
        };

        function viewProfile(index){
            $('.modal').modal('show');
            $('.modal-body').html('<img src="/img/ajaxloading.gif" class="loading-img" alt="">');
            $.ajax({
                url: "/students/"+index,
                type: 'GET',
                success: function(res) {
                    $('.modal-body').html(res);
                    console.log(res);
                }
            });
        }
    </script>
@endsection

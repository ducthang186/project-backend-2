@if(!empty($items) && (!$items->isEmpty()) )
    <?php
    $withs = [
        'order' => '5%',
        'name' => '40%',
        'updated_at' => '40%',
        'operations' => '10%',
        'delete' => '5%',
    ];

    global $counter;
    $nav = $items->toArray();
    $counter = ($nav['current_page'] - 1) * $nav['per_page'] + 1;
    ?>
    <caption>
        @if($nav['total'] == 1)
            {!! trans($plang_admin.'.descriptions.counter', ['number' => $nav['total']]) !!}
        @else
            {!! trans($plang_admin.'.descriptions.counters', ['number' => $nav['total']]) !!}
        @endif
    </caption>

    <table class="table table-hover">

        <thead>
        <tr style="height: 50px;">

            <!--ORDER-->
            <th style='width:{{ $withs['order'] }}'>
                {{ trans($plang_admin.'.columns.order') }}
            </th>

            <!-- NAME -->
            <?php $name = 'slideshow_name' ?>

            <th class="hidden-xs" style='width:{{ $withs['name'] }}'>{!! trans($plang_admin.'.columns.name') !!}
                <a href='{!! $sorting["url"][$name] !!}' class='tb-id' data-order='asc'>
                    @if($sorting['items'][$name] == 'asc')
                        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                    @elseif($sorting['items'][$name] == 'desc')
                        <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @endif
                </a>
            </th>

            <!-- NAME -->
            <?php $name = 'updated_at' ?>

            <th class="hidden-xs"
                style='width:{{ $withs['updated_at'] }}'>{!! trans($plang_admin.'.columns.updated_at') !!}
                <a href='{!! $sorting["url"][$name] !!}' class='tb-id' data-order='asc'>
                    @if($sorting['items'][$name] == 'asc')
                        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                    @elseif($sorting['items'][$name] == 'desc')
                        <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @endif
                </a>
            </th>

            <!--OPERATIONS-->
            <th style='width:{{ $withs['operations'] }}'>
                <span class='lb-delete-all'>
                    {{ trans($plang_admin.'.columns.operations') }}
                </span>

                {!! Form::submit(trans($plang_admin.'.buttons.delete-in-trash'), array(
                                                                           "class"=>"btn btn-danger pull-right delete btn-delete-all del-trash",
                                                                           "title"=> trans($plang_admin.'.hint.delete-in-trash'),
                                                                           'name'=>'del-trash'))
               !!}
                {!! Form::submit(trans($plang_admin.'.buttons.delete-forever'), array(
                                                                            "class"=>"btn btn-warning pull-right delete btn-delete-all del-forever",
                                                                            "title"=> trans($plang_admin.'.hint.delete-forever'),
                                                                            'name'=>'del-forever'))
                !!}
            </th>
            </th>

            <!--DELETE-->
            <th style='width:{{ $withs['delete'] }}'>
                <span class="del-checkbox pull-right">
                    <input type="checkbox" id="selecctall"/>
                    <label for="del-checkbox"></label>
                </span>
            </th>

        </tr>

        </thead>

        <tbody>
        @foreach($items as $item)
            <tr>
                <!--COUNTER-->
                <td> <?php echo $counter; $counter++ ?> </td>

                <!--NAME-->
                <td> {!! $item->slideshow_name !!} </td>

                <!--UPDATED AT-->
                <td> {!! $item->updated_at !!} </td>

                <!--OPERATOR-->
                <td>
                    <!--edit-->
                    <a href="{!! URL::route('slideshows.edit', [   'id' => $item->id,
                                                                '_token' => csrf_token()
                                                            ])
                            !!}">
                        <i class="fa fa-edit f-tb-icon"></i>
                    </a>

                    <!--copy-->
                    <a href="{!! URL::route('slideshows.copy',[    'cid' => $item->id,
                                                                '_token' => csrf_token(),
                                                            ])
                             !!}"
                       class="margin-left-5">
                        <i class="fa fa-files-o f-tb-icon" aria-hidden="true"></i>
                    </a>

                    <!--delete-->
                    <a href="{!! URL::route('slideshows.delete',[  'id' => $item->id,
                                                                '_token' => csrf_token(),
                                                              ])
                             !!}"
                       class="margin-left-5 delete">
                        <i class="fa fa-trash-o f-tb-icon"></i>
                    </a>

                </td>

                <!--DELETE-->
                <td>
                    <span class='box-item pull-right'>
                        <input type="checkbox" id="<?php echo $item->id ?>" name="ids[]" value="{!! $item->id !!}">
                        <label for="box-item"></label>
                    </span>
                </td>

            </tr>
        @endforeach

        </tbody>

    </table>
    <div class="paginator">
        {!! $items->appends($request->except(['page']) )->render() !!}
    </div>
@else
    <!--SEARCH RESULT MESSAGE-->
    <span class="text-warning">
        <h5>
            {{ trans($plang_admin.'.descriptions.not-found') }}
        </h5>
    </span>
    <!--/SEARCH RESULT MESSAGE-->
@endif

@section('footer_scripts')
    @parent
    {!! HTML::script('packages/foostart/js/form-table.js')  !!}
@stop

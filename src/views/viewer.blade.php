<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <title>Laravel 4 LogViewer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        {{ HTML::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap.no-icons.min.css') }}
        {{ HTML::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css') }}
        {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css') }}
        {{ HTML::style('packages/kmd/logviewer/css/style.css') }}
        
        <link rel="shortcut icon" href="{{ URL::to('packages/kmd/logviewer/ico/favicon.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::to('packages/kmd/logviewer/ico/apple-touch-icon-144-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to('packages/kmd/logviewer/ico/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to('packages/kmd/logviewer/ico/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ URL::to('packages/kmd/logviewer/ico/apple-touch-icon-57-precomposed.png') }}">
        
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js') }}
    </head>
    
    <body>
        
        <div class="wrapper">
            
            <div class="container-fluid">
                
                <header>
                    <div class="navbar navbar-static-top navbar-inverse">
                        <div class="navbar-inner">
                            <div class="container-fluid">
                                {{ HTML::link('logviewer', 'Laravel LogViewer', ['class' => 'brand']) }}
                                <ul class="nav">
                                    @foreach (Lang::get('logviewer::logviewer.levels') as $level)
                                        {{ HTML::nav_item('logviewer/' . Request::segment(2) . '/' . Request::segment(3) . '/' . $level, ucfirst($level)) }}
                                    @endforeach
                                </ul>
                                @if ( ! $empty)
                                    <div class="pull-right">
                                        {{ HTML::link('#delete_modal', Lang::get('logviewer::logviewer.delete'), array('class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete_modal')) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>
                
                <div class="row-fluid">
                    
                    <div class="span2">
                        <div id="nav" class="well">
                            <ul class="nav nav-list">
                                @if ($logs)
                                    @foreach ($logs as $type => $files)
                                        <li class="nav-header">{{ $files['sapi'] }}</li>
                                        <ul class="nav nav-list">
                                            @foreach ($files['logs'] as $file)
                                                {{ HTML::decode(HTML::nav_item('logviewer/' . $type . '/' . $file . '/' . Request::segment(4), $file)) }}
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <div class="span10">
                        {{ $paginator->links() }}
                        <div id="log" class="well">
                            @if ( ! $empty)
                                @foreach ($log as $l)
                                    <div class="alert alert-block alert-{{ $l['level'] }}">
                                        <span title="Click to toggle stack trace" class="toggle-stack"><i class="icon-expand-alt"></i></span>
                                        <span class="stack-header">{{ $l['header'] }}</span>
                                        <pre class="stack-trace">{{ $l['stack'] }}</pre>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-block">
                                    {{ Lang::get('logviewer::logviewer.empty', array('sapi' => $sapi, 'date' => $date)) }}
                                </div>
                            @endif
                        </div>
                        {{ $paginator->links() }}
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
        <div id="delete_modal" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this log?</p>
            </div>
            <div class="modal-footer">
                {{ HTML::link('logviewer/' . Request::segment(2) . '/' . Request::segment(3) . '/delete', 'Yes', array('class' => 'btn btn-success')) }}
                <button class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
        </div>
        
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
        <script>window.jQuery || document.write('<script src="{{ URL::to("packages/kmd/logviewer/js/jquery-1.9.1.min.js") }}"><\/script>')</script>
        {{ HTML::script('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js') }}
        {{ HTML::script('packages/kmd/logviewer/js/script.js') }}
        
    </body>
    
</html>
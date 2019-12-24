@if(!isset($active)) @php $active='' @endphp @endif
<div class="sidebar">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li @if($active == 'propositions') class="active" @endif>
                    <a href="{{route('propositions')}}">
                        <i class="iconsmind-Idea-3"></i> Propositions
                    </a>
                </li>
                <li @if($active == 'projects') class="active" @endif>
                    <a href="{{route('projects')}}">
                        <i class="iconsmind-Bridge"></i>
                        <span>Projects</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>


</div>

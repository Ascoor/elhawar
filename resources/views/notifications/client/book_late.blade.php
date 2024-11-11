<li class="top-notifications">
    <div class="message-center">
        <a href="" target="_blank">
            <div class="user-img">
                <span class="btn btn-circle btn-success"><i class="fa fa-tasks"></i></span>
            </div>
            <div class="mail-contnet">
                <small>{{ ucfirst($notification->data['number'].__('modules.libraries.of') .$notification->data['book']) }}</small>
                <span class="mail-desc m-0">@lang('modules.libraries.book_late')</span>
                <span class="time">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</span>
            </div>
        </a>
    </div>
</li>
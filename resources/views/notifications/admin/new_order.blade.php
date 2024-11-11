<li class="top-notifications">
    <div class="message-center">
        <a href="{{route('admin.orders.reply',[$notification->data['order']])}}" target="_blank">
            <div class="user-img">
                <span class="btn btn-circle btn-success"><i class="fa fa-tasks"></i></span>
            </div>
            <div class="mail-contnet">
                <small>{{ ucfirst($notification->data['name']) }}</small>
                <span class="mail-desc m-0">@lang('modules.orders.new_order')</span>
                <span class="time">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</span>
            </div>
        </a>
    </div>
</li>
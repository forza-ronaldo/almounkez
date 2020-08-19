<div >
    <table >
        <thead>
        <tr>
            <th scope="col">@lang('site.image')</th>
            <th scope="col">@lang('site.id')</th>
            <th scope="col">@lang('site.name')</th>
            <th scope="col">@lang('site.email')</th>
            <th scope="col">@lang('site.created_at')</th>
            <th scope="col">@lang('site.updated_at')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>
                    <img src="{{asset('Uploads/UserImage/'.$user->image)}}" width="100" >
                </td>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" >@lang('site.empty')</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

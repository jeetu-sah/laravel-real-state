<a href="{{ url('admin/partner_list') }}" data-toggle="tooltip" title="Users List" class="btn btn-primary float-right" style="margin-right: 5px;">
    <i class="fas fa-list"></i> 
  Users List
  </a>
<a href="{{ url('admin/partner/add_partner') }}" data-toggle="tooltip" title="Add Users" class="btn btn-primary float-right" style="margin-right: 5px;">
        <i class="fas fa-plus"></i> 
  Add Partners
</a>
@permission('admin-users-roles-management')
<a href="{{ url('admin/users_allocation') }}" data-toggle="tooltip" title="Users Allocations" class="btn btn-success float-right" style="margin-right: 5px;">
      <i class="fas fa-list"></i> 
Users Allocation
</a>
@endpermission
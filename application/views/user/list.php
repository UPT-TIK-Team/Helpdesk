<!-- Dashboard Counts Section-->
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card  custom-border-radius">
                    <!--                    <div class="card-header d-flex align-items-center">-->
                    <!--                        <h3 class="h4"><i class="fa fa-ticket"></i> -->
                    <? //= $title ?><!--</h3>-->
                    <!--                    </div>-->

                    <!--                    getSeverityMapping($ticket['severity'])['label']-->
                    <!--                    <td class="text-center">' . toDate($ticket['created']) . '</td>-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive" id="users">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript">
    $(function () {
        
        var options = {
            datatable: {
                columns: [
                    {
                        title: "ID",
                        data: "id",
                        render: function (data) {
                            return data
                        }
                    },
                    {
                        title: "Name",
                        data: "name",
                        render: function (data) {
                            return data;
                        }
                    },
                    {
                        title: "Email",
                       data: "email",
                        render: function (data) {
                            return data;
                        }
                    },
                    {
                        title: "Mobile",
                       data: "mobile",
                        render: function (data) {
                            return data? data : '-'
                        }
                    },
                    {
                        title: "Username",
                        data: "username",
                        render: function (data) {
                            return '<span class="user-name" data-username="'+data+'"></span>';
                        }
                    },
                    {
                        title: "Type",
                        data: "type",
                        render: function (data, type, row) {
                            return '<span class="user-type" data-value="'+data+'"></span>'
                        }
                    },
                    {
                        title: "Status",
                        data: "status",
                        render: function (data, type, row) {
                            // return '<span class="user-status" data-value="'+data+'"></span>'
                        return '<a href="' + BASE_URL + 'user/profile_update/' + data + '" style="color: gray; text-decoration:none;">' + '<span class="user-status" data-value="'+data+'"></span>' + '</a>'
                        }
                    },
                    {
                        title: "Created On",
                        data: "created",
                        render: function (data) {
                            return data?'<span class="rel-time" data-value="'+data+'000">':'-';
                        }
                    },
                ]
            }
        };
        var my_tik_table =  makeReportPage($('#users'), 'list_users', options, function(err, data){
            data.table.on('draw', function(){
                renderCustomHTML();
                $('[data-toggle="tooltip"]').tooltip(); 
            })
        });

       

    });
</script>

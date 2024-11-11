--------------------------------------
[19-09-2023]
SQL:

Table: daily_records_entries:

amount (updated) from : `amount(10,2)` to : `amount(20,2)`

CODE:

path: */Modules/Accounting/Resources/views/dailyrecords/index.blade.php*

Replace: *Line 136,137* with :
```
'<a href="{{route('admin.accounting.dailyrecords.print')}}/'+data+'" class="btn btn-primary p-2 m-1" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="{{route('admin.accounting.dailyrecords.preview')}}/'+data+'" class="btn btn-primary p-2 m-1"  target="_blank"><i class="fa fa-eye " aria-hidden="true"></i></a><a href="{{route('admin.accounting.dailyrecords.edit',$viewData["type"])}}/'+data+'" class="btn btn-primary p-2 m-1" ><i class="fa fa-edit" aria-hidden="true"></i></a><a  href="{{route('admin.accounting.dailyrecords.destroy',$viewData["type"])}}/'+data+'" onclick="confirmDelete('+data+')" class=" btn btn-danger p-2 m-1" ><i class="fa fa-trash" aria-hidden="true"></i></a>' :  data;
```


Done and uploaded
-

--------------------------------------
[18-09-2023]

SQL:
Table: Dailyrecord_entries:
+`user_id`

SQL:

Table: Salary_slip:

+`penality_duration`

+`deduction_reason`


Done and uploaded
-
----------------------------------------

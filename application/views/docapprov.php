<!--
Have to go through this code and take out what is not needed
I only want a button to show allowing the admin to approve the 
doc once the doc is aporoved I want the Approve column to change 
to true. 

Have to make a function like docuemnts/saveEdit which will change 
the document value of Approved to True in the data base.
-->

<h1>Approve Documents</h1>
<!-- This table makes a box so that i can show a signature without it you cant -->
<p>List of all documents</p>  

<div id="example2" class="k-content">
  <div id="document_grid2"  style="font-size:11px;"> </div>
  <br>
  <br>
  <div class = 'k-content k-state-active' id = "contentArea2"> 

  </div>
  <br>
  <br>
  <div id = "Pad2">
  </div>

  <script>

    
    
    /*
    IMPORTANT:
    have to create a new func in documents
    controller for editing docs
    
    have to make a form to send the info 
    to that new func
    
    
    WARNING CLICKING ON SAME USER GIVES
    ERROR!!!
    */
    function consoleLogSelection2(e)
    {
     var isSet = false;
     var grid2 = $("#document_grid2").data("kendoGrid");
 

     $(grid2.tbody).on("click", "td", function (e) 
     {
		     console.log("hey");	
  });
}
$(document).ready(function() 
{
  $("#document_grid2").kendoGrid(
  {
    dataSource: {
      type: "jsonp",
      serverPaging: true,
      serverSorting: true,
      pageSize: 30,
                //this reads in data from docments service, this is java script code
                transport: {
                  read: "<?php echo $exepath; ?>documents/documents_service"
                },

                schema: {
                  data: function(result) {
                    return result.Result || result;


                  },
                  total: function(result)
                  {
                    return result.PageSize || result.length || 0;
                  }
                }
              },
              dataBound: consoleLogSelection2,
              scrollable: false,
              sortable: true,
              pageable: {
                pageSize: 30
              },
            // data binds to these columns have to open up the object 
            columns: [
            { field: "approved", title: "Approved", width: 60},
            { field: "title", title: "Title", width: 90},
            { field: "document_id", title: "Doc ID", width: 60 },
            { field: "user_id", title: "User", width: 90 },
            { field: "date_added", title: "Date Added", width: 90 },
            ]

          });

});
</script>
</div>



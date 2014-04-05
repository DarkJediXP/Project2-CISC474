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
<p>List of all documents that need approval:</p>  

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
     var isSet2 = false;
     var grid2 = $("#document_grid2").data("kendoGrid");
 

     $(grid2.tbody).on("click", "td", function (e) 
     {
		     console.log("hey");	
		     {
     	/*
     	Keeps the rest of the handlers from being executed and prevents the event from bubbling up the DOM tree.
     	*/
     	e.stopImmediatePropagation(); 
   
     	grid2 = $("#document_grid2").data("kendoGrid");
            // gets the signature cooridnates and outputs to console 
        var this_row2 = $(this).closest("tr"); // grabs the nearest row here user clicked
        var this_rowIdx2 = $("tr", grid2.tbody).index(this_row2);
        var colIdx2 = $("td", row2).index(this);
        var row2 = grid2.tbody.find(":nth-child("+ this_rowIdx2 +")").find(":nth-child(4)").html(); //giving me html row
		console.log($("#document_grid2").data("kendoGrid")._data[this_rowIdx2]);
       
       //catches any erro that the JSON object my throw
        try {
				var sig2 = JSON.parse($("#document_grid2").data("kendoGrid")._data[this_rowIdx2].signature); 
				} catch(err) {
						console.log("error in JSON.parse()");
						}
						
        var pad2 = document.getElementById("Pad2")
        var documentContent2 = $("#document_grid2").data("kendoGrid")._data[this_rowIdx2].content;
        var this_doc_id2 = $("#document_grid2").data("kendoGrid")._data[this_rowIdx2].document_id;
        //Gives an HTML form element  
        $("#document_grid2").data("kendoGrid")._data[this_rowIdx2].signature = document.getElementById("wrapsig2"); 
        $("#document_grid2").data("kendoGrid").refresh(); // refreshes the view after switching to hello
        
        /*
        Checking to see if this is the first time that a user 
        has a selected a document from the list if it is it creates
        a new k-textbox and and sets the flag
        */
        if(!isSet2)
        {    
        
        //creates a html to show the signature
         var div2 = document.createElement('div2');
         div2.className = 'content';
         div2.innerHTML = ' <td>This user has signed this document:<br><br></td><td valign="top"><form method="post" action="" class="sigPad" id="sigPadInput2"><div id = "wrapsig2" class="sig sigWrapper"> <div class="typed"></div><canvas class="pad" width="98" height="55"></canvas><input type="hidden" name="output" class="output"></div> </form></td></tr>'; 
         document.getElementById('Pad2').appendChild(div2); 
         
		 /*
		 This creates html to show the doucment preview for the user
		 the use can click the edit button which creates a kendo editor 
		 that the user can use to edit the document. 
		 */
		 var sdiv2 = document.createElement('sdiv2');
         sdiv2.className = 'k-content k-state-active';
         sdiv2.innerHTML = '<div id="dochead2">Document Preview</div><br><form id="documentForm3" action="<?php echo $exepath; ?>documents/approve" method="POST" onsubmit="return submitForm();">Document ID:<input class = "k-textbox" type="text" name="doc_id2" id="edit_doc_id2" style="width: 50px;" readonly><br><textarea class="k-textbox" name="editedContent2" id="contentTextArea2" style = "resize: none"; readonly rows="10" cols="100">  </textarea><br><button type="submit" class="k-button" id="approvebutton">Approve Document</button></form>';
         
         
         document.getElementById('contentArea2').appendChild(sdiv2); 
         document.getElementById('contentTextArea2').value = documentContent2;
         /*
         I have to set the value of the input fields after declaring
         them so that I can post these values to my function action_saveEdit
         */
         document.getElementById('edit_doc_id2').value = this_doc_id2;
     
         


         isSet2 = true;        
       }
       else
       {
                document.getElementById('contentTextArea2').value = documentContent2;
                document.getElementById('edit_doc_id2').value = this_doc_id2;
        }



              $("#document_grid2").data("kendoGrid")._data[this_rowIdx2].signature =  $(document).ready(function () 
              {
                $('.sigPad').signaturePad({displayOnly:true}).regenerate(sig2);
              });  

            }
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
                  read: "<?php echo $exepath; ?>documents/documents_service2"
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



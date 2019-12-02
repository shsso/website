<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<script>
  $(function(){
    customTag("doc", null);
    customTag("date-docs", dateDocs);
    if (!$("div#docslist li").length)
      $("div#docslist").before("<p>No documents have been added yet, be sure to check back soon!</p>");
  }
);

function customTag(tagName, fn){
  document.createElement(tagName);
  if (fn != null) {
    var tagInstances = document.getElementsByTagName(tagName);
    $(tagName).after(function(index) {
      return fn(tagInstances[index]);
    });
    $(tagName).remove();
  }
}

function dateDocs(element) {
  var date = element.attributes.date.value;
  var newHTML = "<li>" + date + "<ul>";
  var items = element.querySelectorAll("doc");
  for(var i = 0; i < items.length; i++) {
    var doc = items[i];
    var text = doc.attributes.text.value;
    var link = doc.attributes.link.value;
    newHTML += "<li><a target=\"_blank\" href=\"" + link + "\">" + text + "</a></li>";
  }
  newHTML += "</ul></li>";
  return newHTML;
}

</script>

<h1 align="center">Important Documents (Team Minutes and More!)</h1>
<hr>
<div id="docslist">
   <ul>

<!--Template
    <date-docs date="">
        <doc text="" link="">
    </date-docs>
-->
    <date-docs date="March 1st, 2018">
        <doc text="3/1/18 Minutes" link="https://bit.ly/2FLiNd6">
    </date-docs>
    <date-docs date="February 22nd, 2018">
        <doc text="2/22/18 Minutes" link="https://bit.ly/2Fhviz9">
    </date-docs>
    <date-docs date="February 15th, 2018">
        <doc text="2/15/18 Minutes" link="https://bit.ly/2Gf5AYW">
    </date-docs>
    <date-docs date="February 8th, 2018">
        <doc text="2/8/18 Minutes" link="https://bit.ly/2BOy7Xh">
    </date-docs>
    <date-docs date="February 1st, 2018">
        <doc text="2/1/18 Minutes" link="https://bit.ly/2sgP8oR">
    </date-docs>
    <date-docs date="January 11th, 2018">
        <doc text="1/11/18 Minutes" link="https://bit.ly/2Bih8vb">
    </date-docs>
    <date-docs date="December 14th, 2017">
        <doc text="12/14/17 Minutes" link="https://bit.ly/2oaBO3w">
    </date-docs>
    <date-docs date="December 7th, 2017">
        <doc text="12/7/17 Minutes" link="https://bit.ly/2y8dHSF">
    </date-docs>
    <date-docs date="November 30th, 2017">
         <doc text="11/30/17 Minutes" link="https://bit.ly/2kjflzx">
    </date-docs>
    <date-docs date="November 16th, 2017">
        <doc text="11/16/17 Minutes" link="https://bit.ly/2AEZNN3">
    </date-docs>
    <date-docs date="November 9th, 2017">
        <doc text="11/9/17 Minutes" link="https://bit.ly/2jFveMG">
    </date-docs>
    <date-docs date="November 2nd, 2017">
        <doc text="11/2/17 Minutes" link="https://bit.ly/2no9UAy">
        <doc text="Invitational Permission Form" link="https://bit.ly/2BEy8JW">
    </date-docs>
    <date-docs date="October 19th, 2017">
        <doc text="10/19/17 Minutes" link="https://bit.ly/2BuMziD">
    </date-docs>
    <date-docs date="October 5th, 2017">
        <doc text="10/5/2017 Minutes" link="https://bit.ly/2kjfFOL">
    </date-docs>
    <date-docs date="September 28th, 2017">
        <doc text="9/28/17 Minutes" link="https://bit.ly/2kmhdYw">
    </date-docs>
    <date-docs date="September 14th, 2017">
        <doc text="9/14/17 Minutes" link="https://bit.ly/2kmhIBS">
        <doc text="Whirlyball 10/8/17 RSVP" link="https://bit.ly/2AHtf5j">
        <doc text="2017-2018 SHSSO Student Parent Contact Information Survey" link="https://bit.ly/2icNj4m">
        <doc text="Whirlyball Release Form" link="/DivC/downloads/Whirlyball2018Release.pdf">
    </date-docs>
    <date-docs date="September 7th, 2017">
        <doc text="9/7/17 Minutes" link="https://bit.ly/2zIoHYw">
    </date-docs>
    <date-docs date="August 31st, 2017">
        <doc text="8/31/17 Minutes" link="https://bit.ly/2zI6gDc">
    </date-docs>
    <date-docs date="August 24th, 2017">
        <doc text="8/24/17 Minutes" link="https://bit.ly/2kme0It">
        <doc text="8/24/17 Meeting Agenda" link="/DivC/downloads/8.24.17%20SHSSO%20Meeting%20Agenda.pdf">
        <doc text="2017-18 Membership Agreement" link="/DivC/downloads/2018%20SHSSO%20Membership Agreement.pdf">
    </date-docs>
  </ul>
</div>
<div id="push"></div>
<?php
    include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>

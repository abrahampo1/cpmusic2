var express = require("express");
var bodyParser = require("body-parser");
var app = express();
var fs = require("fs");
app.use(bodyParser.urlencoded());
app.use(
  bodyParser.urlencoded({
    extended: true,
  })
);

app.get('/playing', (req,res)=>{
  res.send(variable('now'))
})
app.get('/reload', (req,res)=>{
  res.send('reloaded')
  location.reload()
})
app.post("/add", function (req, res) {
  console.log(req.body);
  let url = decodeURIComponent(req.body.url);
  add_queue(url);
  res.send("OK");
});

if (server == null) {
  var server = app.listen(5757, function () {
    var host = server.address().address;
    var port = server.address().port;
    console.log("Server Listening To " + host + " on port " + port);
  });
}

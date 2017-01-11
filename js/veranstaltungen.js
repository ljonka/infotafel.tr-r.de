var d1 = new Date();
d1.setDate(d1.getDate());
var d2 = new Date();
d2.setDate(d2.getDate() + 7);

$.getJSON("events.php", {
    from: d1.valueOf(),
    to: d2.valueOf()
}, function(data, status) {
    var template = $("#entrytemplate").first();
    var count = 0;
    data.result.forEach(function(event) {
        ++count;
        if (count < 7) {
            var entry = template.clone();
            entry.find(".title").html(event.title);
            entry.find(".start").append((new Date(parseInt(event.start))).format("M jS, Y - H:i"));
            entry.find(".ort").append(event.location);
            entry.find(".description").append(event.description);
            //entry.find("p").html(event.description);
            entry.show();
            template.parent().append(entry);
        }
    });
});


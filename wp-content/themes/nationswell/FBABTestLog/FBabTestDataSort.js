var public_spreadsheet_url = 'https://docs.google.com/spreadsheet/pub?key=0AvVxrKGf5A3fdE9HSGhsNkVmaURSdkQ0MWQ1dlV2cWc&single=true&gid=6&output=html';

var tabletop = Tabletop.init( { key: public_spreadsheet_url,
                     callback: displayResults,
                     simpleSheet: true,
                     orderby: 'datetime',
                     reverse: true,
                     parseNumbers: true
                 } );

function displayResults(rows) {
	console.log(rows);
	var dataset = rows.reverse();
	var bar = 	d3.select("#datadrop").selectAll("div")
					.data(dataset)
					.enter()
					.append("div")
					.classed("test",true)
					.style("border-bottom","1px solid #e4e4e9")
					.style("background-color", function(d) {
						if (d.method === "Paid") {
							return "#f3f3f3"
						}
						else if ((d.testnum) % 2 === 1) {
							return "#f6f6f6"
						}
						else {
							return "#f1f1f1"
						};
					})
					.style("margin-bottom", function(d) {
						if (d.variation === "A") {
							return "40px"
						}
						else {
							return "0px"
						};
					})
					.style("display",function(d) {
						if (d.testtype === "hed") {
								return ("inline-block;")
							}
						else if (d.testtype === "pt") {
								return ("inline-block;")
							}
						else {
							return ("none")
						};
					});
	var testsummary = d3.selectAll(".test")
							.append("div")
							.classed("testsummary",true)
							.style("display",function(d) {
									if (d.variation === "B") {
										return "inline-block"
									}
									else {
										return "none"
									};
								});
	testsummary.append("div")
		.classed("datetime",true)
		.text(function(d) {return d.datetime});
	testsummary.append("a")
		.classed("storylink",true)
		.attr("href", function(d) {return d.storylink})
		.attr("target","_blank")
		.text("Story Link");
	testsummary.append("div")
		.classed("testtype",true)
		.text(function(d) {
			if (d.testtype === "hed") {
				return "Headline"
			}
			else if (d.testtype === "pt") {
				return "Post Text"
			}
			else {};
		});
	bar.append("div")
		.classed("varrow",true)
		.text(function(d) {
			if (d.testtype === "hed") {
					return (d.hed)
				}
			else if (d.testtype === "pt") {
					return (d.posttext)
				}
			else {
				return ("coming soon")
			};
		});
	bar.append("br");
	bar.append("div")
		.classed("engbar",true)
		.style("width",function(d) {return d.engagementrate * 5000 + "px"})
		.style("display",function(d) {
			if (d.impressions === "a") {
				return "none"
			}
			else {
				return "inline-block"
			}
		});
	bar.append("div")
		.classed("engnumber",true)
		.text(function(d) {
			if (d.impressions === "a") {
				return "pending"
			}
			else {
				return d3.round((d.engagementrate * 100),2) + "% engagement"}
			})
		.style("margin-left",function(d) {
			if (d.impressions === "a") {
				return "12px"
			}
			else {
				return "0px"
			}
		});
	bar.append("br");
	bar.append("div")
		.classed("engbar",true)
		.style("width",function(d) {return d.websitectr * 5000 + "px"})
		.style("display",function(d) {
			if (d.impressions === "a") {
				return "none"
			}
			else {
				return "inline-block"
			}
		});
	bar.append("div")
		.classed("engnumber",true)
		.text(function(d) {return d3.round((d.websitectr * 100),2) + "% ctr"})
		.style("display",function(d) {
			if (d.impressions === "a") {
				return "none"
			}
			else {
				return "inline-block"
			}
		})
}
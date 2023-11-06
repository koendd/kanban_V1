window.loadStatistics = function (data, div_id) {
    let divWidth = d3.select(div_id).node().clientWidth;
    let divHeight = d3.select(div_id).node().clientHeight;
    if(divHeight < 480) {
        divHeight = 480;
    }

    // set the dimensions and margins of the graph
    var margin = {top: 30, right: 30, bottom: 100, left: 60},
        width = divWidth - margin.left - margin.right,
        height = divHeight - margin.top - margin.bottom;

    // append the svg object to the body of the page
    var svg = d3.select(div_id)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    // X axis
    var x = d3.scaleBand()
        .range([ 0, width ])
        .domain(data.map(function(d) { return d.name; }))
        .padding(0.2);
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .selectAll("text")
        .attr("transform", "translate(-10,6)rotate(-45)")
        .style("text-anchor", "end");

    // Add Y axis
    var y = d3.scaleLinear()
        .domain([0, d3.max(data, function(d) { return d.tasks_count; })])
        .range([ height, 0]);
    svg.append("g")
        .call(d3.axisLeft(y));

    // Bars
    svg.selectAll("mybar")
        .data(data)
        .enter()
        .append("rect")
        .attr("x", function(d) { return x(d.name); })
        .attr("y", function(d) { return y(d.tasks_count); })
        .attr("width", x.bandwidth())
        .attr("height", function(d) { return height - y(d.tasks_count); })
        .attr("fill", function(d) { if(d.colorHex) return "#" + d.colorHex; return "#73a610" ;});
}
import React from "react";
import {CartesianGrid, Line, LineChart, ResponsiveContainer, Tooltip, XAxis, YAxis} from "recharts";

type ReChartProps = {
    data: ChartData[]
}

type ChartData = {
    date: string,
    users: number
}

function ReChart ({data}: ReChartProps){
    return (
        <ResponsiveContainer width={"100%"} height={400}>
            <LineChart width={500} height={400} data={data} margin={{ top: 5, right: 20, left: 10, bottom: 5 }}>
                <YAxis dataKey="users" />
                <XAxis dataKey="date"/>
                <Tooltip />
                <CartesianGrid stroke="#f5f5f5" />
                <Line type="monotone" dataKey="date" stroke="#ff7300"  />
                <Line type="monotone" dataKey="users" stroke="#387908" />
            </LineChart>
         </ResponsiveContainer>
    )
}

export default ReChart;
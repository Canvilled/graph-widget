import React from "react";
import useSWR from "swr";
import {Loading} from "./loading";
import ReChart from "./rechart";

function App() {
	const [days, setDays] = React.useState(7);
	const {restUrl} = window.graphWidget;
	const {data,isLoading} = useSWR(`${restUrl}?days=${days}` , async (url) => {
		const response = await fetch(url);
		return response.json();
	});

	return (
		<div>
			{
				isLoading ? <div className={'loading-screen'}>
					<Loading/>
				</div> : (
					<>
						<div className={'flex justify-between items-center mb-4'}>
							<h2 >
								Graph Widget
							</h2>
							<select value={days} onChange={(e: React.ChangeEvent<HTMLSelectElement> ) => setDays(parseInt(e.target.value))}>
								<option value={7}>Last 7 days</option>
								<option value={15}>Last 15 days</option>
								<option value={30}>Last month</option>
							</select>
						</div>
						<ReChart data={data}/>
					</>
				)
			}
		</div>
	);
}

export default App;

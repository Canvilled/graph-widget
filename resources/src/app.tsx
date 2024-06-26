import React from 'react';
import useSWR from 'swr';
import { Loading } from './loading';
import ReChart, { ChartData } from './rechart';
import apiFetch from '@wordpress/api-fetch';
import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

// We use functional component here as this is more common in modern React
function App() {
 // Proper indentation for readability
 const [days, setDays] = React.useState( 7 );
 const { restUrl } = window.graphWidget;
 const { data, isLoading } = useSWR(`${restUrl}?days=${days}`, async (url) => {
  // adhere WordPress standards for whitespaces
  return await apiFetch({ url: url });
 });

 return (
     // Explicitly use className instead of class
     <div className="app-container">
      {
       isLoading
           ? (
               <div className={'loading-screen'}>
                <Loading />
               </div>
           )
           : (
               <>
                <div className={'flex justify-between items-center mb-4'}>
                 <h2>
                  { __('Graph Widget', 'graph-widget') }
                 </h2>
                 <SelectControl
                     value={ days.toString() }
                     options={[
                      { label: __('Last 7 days', 'graph-widget'), value: '7' },
                      { label: __('Last 15 days', 'graph-widget'), value: '15' },
                      { label: __('Last month', 'graph-widget'), value: '30' },
                     ]}
                     onChange={(value) => setDays(parseInt(value))}
                 />
                </div>
                <ReChart data={ data as ChartData[] } />
               </>
           )
      }
     </div>
 );
}

export default App;
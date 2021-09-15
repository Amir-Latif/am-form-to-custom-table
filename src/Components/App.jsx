import CreateTable from './CreateTable.jsx';

function App() {
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries());

    let component = <CreateTable />;
    if (params.page === 'AMFTUT') {
        component = <CreateTable />
    }
    else if (params.page === 'data-retrieval') {
        component = <ReadTable />
    }

    return (
        component
    )
}

export default App;
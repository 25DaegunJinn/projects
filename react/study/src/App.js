import logo from './logo.svg';
import './App.css';


function Greet(props) {
  return <h1>Hello, {props.name}!</h1>
}
function App() {
  const items = [
    {
      name: "이주경",
      age: 17
    },
    {
      name: "김민지",
      age: 18
    },
    {
      name: "박서연",
      age: 19
    }
  ]

  return (
    <div className="App">
      <header className="App-header">
      <ul>
        {items.map((v, i) => (
          <li key={i}><h4>{v.name}</h4>{v.age}</li>
        ))}
      </ul>
      </header>
    </div>
  );
}

export default App;

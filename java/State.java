interface State { 
	void writeName(StateContext stateContext, String name);
} 

class StateA implements State { 
	public void writeName(StateContext stateContext, String name) { 
		System.out.println(name.toLowerCase()); 
		stateContext.setState(new StateB()); 
	} 
} 

class StateB implements State { 
	private int count=0; 
	public void writeName(StateContext stateContext, String name){ 
		System.out.println(name.toUpperCase()); 
		// StateBのwriteName()が2度呼び出された後に状態を変化させる
		if(++count>1) { 
			stateContext.setState(new StateA()); 
		}
	}
}




public class StateContext {
	private State myState; 
	public StateContext() { 
		setState(new StateA()); 
	} 
	
	// 通常は、Stateインタフェースを実装しているクラスによってのみ呼び出される
	public void setState(State newState) { 
		this.myState = newState; 
	}
	
	public void writeName(String name) { 
		this.myState.writeName(this, name); 
	} 
}






public class TestClientState { 
	public static void main(String[] args) { 
		StateContext sc = new StateContext(); 
		sc.writeName("Monday"); 
		sc.writeName("Tuesday"); 
		sc.writeName("Wednesday"); 
		sc.writeName("Thursday"); 
		sc.writeName("Saturday"); 
		sc.writeName("Sunday"); 
	}
}


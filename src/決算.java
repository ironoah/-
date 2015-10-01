class 決算 {
	
	public void 収益・費用の各勘定残高を損益勘定に振り替える() {
	}
	
	public void 当期純利益を資本金勘定に振り替える() {
	}
	
	public boolean 各勘定を締め切る() {
		if (売上.借方.損益 != 売上.貸方.現金 +  売上.貸方.売掛金) {
			return false;
		}
		if (損益.借方.仕入 + 損益.借方.資本金 != 損益.貸方.売上) {
			return false;
		}
		if (仕入.借方.現金 + 仕入.借方.買掛金 != 仕入.貸方.損益) {
			return false;
		}
		return true;
	}
	
	public void 繰越試算表を作成する() {
	}
}
